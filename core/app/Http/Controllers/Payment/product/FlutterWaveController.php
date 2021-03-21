<?php

namespace App\Http\Controllers\Payment\product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\OrderItem;
use App\PaymentGateway;
use App\Product;
use App\ProductOrder;
use App\ShippingCharge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PDF;

class FlutterWaveController extends Controller
{
    public $public_key;
    private $secret_key;

    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('flutterwave')->first();
        $paydata = $data->convertAutoData();
        $this->public_key = $paydata['public_key'];
        $this->secret_key = $paydata['secret_key'];
    }

    public function store(Request $request)
    {
        if (!Session::has('cart')) {
            return view('errors.404');
        }
        $available_currency = array('BIF', 'CAD', 'CDF', 'CVE', 'EUR', 'GBP', 'GHS', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'NGN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'USD', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD');

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extra;
        $bs = $currentLang->basic_setting;

        if (!in_array($bex->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', __('Invalid Currency For Flutterwave.'));
        }

        $cart = Session::get('cart');

        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            if ($product->stock < $item['qty']) {
                Session::flash('stock_error', $product->title . ' stock not available');
                return back();
            }
            $total  += $product->current_price * $item['qty'];
        }

        if ($request->shipping_charge != 0) {
            $shipping = ShippingCharge::findOrFail($request->shipping_charge);
            $shippig_charge = $shipping->charge;
        } else {
            $shippig_charge = 0;
        }

        $total = round($total + $shippig_charge, 2);


        $rules = [
            'billing_fname' => 'required',
            'billing_lname' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_country' => 'required',
            'billing_number' => 'required',
            'billing_email' => 'required',
            'shpping_fname' => 'required',
            'shpping_lname' => 'required',
            'shpping_address' => 'required',
            'shpping_city' => 'required',
            'shpping_country' => 'required',
            'shpping_number' => 'required',
            'shpping_email' => 'required'
        ];

        $request->validate($rules);

        $order = new ProductOrder();
        $order->user_id = Auth::user()->id;
        $order->billing_fname = $request->billing_fname;
        $order->billing_lname = $request->billing_lname;
        $order->billing_email = $request->billing_email;
        $order->billing_address = $request->billing_address;
        $order->billing_city = $request->billing_city;
        $order->billing_country = $request->billing_country;
        $order->billing_number = $request->billing_number;
        $order->shpping_fname = $request->shpping_fname;
        $order->shpping_lname = $request->shpping_lname;
        $order->shpping_email = $request->shpping_email;
        $order->shpping_address = $request->shpping_address;
        $order->shpping_city = $request->shpping_city;
        $order->shpping_country = $request->shpping_country;
        $order->shpping_number = $request->shpping_number;

        $order->total = $total;
        $order->shipping_charge = round($shippig_charge, 2);
        $order->method = "Flutterwave";
        $order->currency_code = $bex->base_currency_text;
        $order->order_number = str_random(4) . time();
        $order->payment_status = 'Pending';
        $order['txnid'] = 'txn_' . str_random(8) . time();
        $order['charge_id'] = 'ch_' . str_random(9) . time();


        $order->save();
        $order_id = $order->id;

        $carts = Session::get('cart');
        $products = [];
        $qty = [];
        foreach ($carts as $id => $item) {
            $qty[] = $item['qty'];
            $products[] = Product::findOrFail($id);
        }


        foreach ($products as $key => $product) {
            if (!empty($product->category)) {
                $category = $product->category->name;
            } else {
                $category = '';
            }
            OrderItem::insert([
                'product_order_id' => $order_id,
                'product_id' => $product->id,
                'user_id' => Auth::user()->id,
                'title' => $product->title,
                'sku' => $product->sku,
                'qty' => $qty[$key],
                'category' => $category,
                'price' => $product->current_price,
                'previous_price' => $product->previous_price,
                'image' => $product->feature_image,
                'summary' => $product->summary,
                'description' => $product->description,
                'created_at' => Carbon::now()
            ]);
        }


        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            $stock = $product->stock - $item['qty'];
            Product::where('id', $id)->update([
                'stock' => $stock
            ]);
        }


        $fileName = str_random(4) . time() . '.pdf';
        $path = 'assets/front/invoices/product/' . $fileName;
        $data['order']  = $order;
        $pdf = PDF::loadView('pdf.product', $data)->save($path);

        ProductOrder::where('id', $order_id)->update([
            'invoice_number' => $fileName
        ]);


        $orderData['item_name'] = $bs->website_title . " Order";
        $orderData['item_number'] = str_random(4) . time();
        $orderData['item_amount'] = $total;
        $orderData['order_id'] = $order_id;
        $orderData['invoice'] = $fileName;
        $cancel_url = route('product.payment.cancle');
        $notify_url = route('product.flutterwave.notify');


        Session::put('order_data', $orderData);
        Session::put('order_payment_id', $orderData['item_number']);

        // SET CURL

        $curl = curl_init();
        $customer_email = $request->billing_email;


        $amount = $order['item_amount'];
        $currency = $bex->base_currency_text;
        $txref = $order['item_number']; // ensure you generate unique references per transaction.
        $PBFPubKey = $this->public_key; // get your public key from the dashboard.
        $redirect_url = $notify_url;
        $payment_plan = ""; // this is only required for recurring payments.


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $amount,
                'customer_email' => $customer_email,
                'currency' => $currency,
                'txref' => $txref,
                'PBFPubKey' => $PBFPubKey,
                'redirect_url' => $redirect_url,
                'payment_plan' => $payment_plan
            ]),
            CURLOPT_HTTPHEADER => [
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the rave API
            return redirect($cancel_url)->with('error', 'Curl returned error: ' . $err);
        }

        $transaction = json_decode($response);

        if (!$transaction->data && !$transaction->data->link) {
            // there was an error from the API
            return redirect($cancel_url)->with('error', 'API returned error: ' . $transaction->message);
        }

        return redirect($transaction->data->link);
    }

    public function notify(Request $request)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;

        $order_data = Session::get('order_data');
        // dd($order_data);
        $success_url = route('product.payment.return');
        $cancel_url = route('product.payment.cancle');
        $input_data = $request->all();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('order_payment_id');

        if (isset($input_data['txref'])) {
            $ref = $payment_id;

            $query = array(
                "SECKEY" => $this->secret_key,
                "txref" => $ref
            );

            $data_string = json_encode($query);

            $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($ch);

            curl_close($ch);

            $resp = json_decode($response, true);
            if ($resp['status'] == 'error') {
                return redirect($cancel_url);
            }

            if ($resp['status'] = "success") {

                $paymentStatus = $resp['data']['status'];
                $chargeResponsecode = $resp['data']['chargecode'];

                if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($paymentStatus == "successful")) {

                    $po = ProductOrder::findOrFail($order_data["order_id"]);
                    $po->payment_status = "Completed";
                    $po->save();


                    // Send Mail to Buyer
                    $mail = new PHPMailer(true);
                    $user = Auth::user();

                    if ($be->is_smtp == 1) {
                        try {
                            $mail->isSMTP();
                            $mail->Host       = $be->smtp_host;
                            $mail->SMTPAuth   = true;
                            $mail->Username   = $be->smtp_username;
                            $mail->Password   = $be->smtp_password;
                            $mail->SMTPSecure = $be->encryption;
                            $mail->Port       = $be->smtp_port;

                            //Recipients
                            $mail->setFrom($be->from_mail, $be->from_name);
                            $mail->addAddress($user->email, $user->fname);

                            // Attachments
                            $mail->addAttachment('assets/front/invoices/product/' . $order_data["invoice"]);

                            // Content
                            $mail->isHTML(true);
                            $mail->Subject = "Order placed for Product";
                            $mail->Body    = 'Hello <strong>' . $user->fname . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                            $mail->send();
                        } catch (Exception $e) {
                            // die($e->getMessage());
                        }
                    } else {
                        try {

                            //Recipients
                            $mail->setFrom($be->from_mail, $be->from_name);
                            $mail->addAddress($user->email, $user->fname);

                            // Attachments
                            $mail->addAttachment('assets/front/invoices/product/' . $order_data["invoice"]);

                            // Content
                            $mail->isHTML(true);
                            $mail->Subject = "Order placed for Product";
                            $mail->Body    = 'Hello <strong>' . $user->fname . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                            $mail->send();
                        } catch (Exception $e) {
                            // die($e->getMessage());
                        }
                    }



                    Session::forget('order_payment_id');
                    Session::forget('order_data');
                    Session::forget('cart');

                    return redirect($success_url);
                }
            }
            return redirect($cancel_url);
        }
        return redirect($cancel_url);
    }
}
