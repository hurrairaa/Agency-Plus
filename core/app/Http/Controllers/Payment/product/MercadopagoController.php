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
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PDF;

class MercadopagoController extends Controller
{
    private $access_token;
    private $sandbox;

    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('mercadopago')->first();
        $paydata = $data->convertAutoData();
        $this->access_token = $paydata['token'];
        $this->sandbox = $paydata['sandbox_check'];
    }

    public function store(Request $request)
    {
        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extra;
        $bs = $currentLang->basic_setting;

        $available_currency = array('ARS','BOB','BRL','CLF','CLP','COP','CRC','CUC','CUP','DOP','EUR','GTQ','HNL','MXN','NIO','PAB','PEN','PYG','USD','UYU','VEF','VES');
        if (!in_array($bex->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', 'Invalid Currency For Mercado Pago.');
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
        $order->method = "Mercado Pago";
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


        $return_url = route('product.payment.return');
        $cancel_url = route('product.payment.cancle');
        $notify_url = route('product.mercadopago.notify');

        $item_name = $bs->website_title . " Order";
        $item_number = Str::random(4) . time();
        $item_amount = (float) $total;


        $curl = curl_init();


        $preferenceData = [
            'items' => [
                [
                    'id' => $item_number,
                    'title' => $item_name,
                    'description' => $item_name,
                    'quantity' => 1,
                    'currency_id' => $bex->base_currency_text,
                    'unit_price' => $item_amount
                ]
            ],
            'payer' => [
                'email' => $request->billing_email,
            ],
            'back_urls' => [
                'success' => $return_url,
                'pending' => '',
                'failure' => $cancel_url,
            ],
            'notification_url' =>  $notify_url,
            'auto_return' =>  'approved',

        ];

        $httpHeader = [
            "Content-Type: application/json",
        ];
        $url = "https://api.mercadopago.com/checkout/preferences?access_token=" . $this->access_token;
        $opts = [
            CURLOPT_URL             => $url,
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => json_encode($preferenceData, true),
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTPHEADER      => $httpHeader
        ];

        curl_setopt_array($curl, $opts);

        $response = curl_exec($curl);
        $payment = json_decode($response,true);

        $err = curl_error($curl);

        curl_close($curl);

        $orderData['order_id'] = $order_id;;
        $orderData['invoice'] = $fileName;

        Session::put('order_data', $orderData);

        if($this->sandbox == 1)
        {
            return redirect($payment['sandbox_init_point']);
        }
        else {
            return redirect($payment['init_point']);
        }
    }

    public function curlCalls($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $paymentData = curl_exec($ch);
        curl_close($ch);
        return $paymentData;
    }

    public function paycancle()
    {
        return redirect()->back()->with('error', 'Payment Cancelled.');
    }

    public function payreturn()
    {
        if (Session::has('tempcart')) {
            $oldCart = Session::get('tempcart');
            $tempcart = new Cart($oldCart);
            $order = Session::get('temporder');
        } else {
            $tempcart = '';
            return redirect()->back();
        }

        return view('front.success', compact('tempcart', 'order'));
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

        $paymentUrl = "https://api.mercadopago.com/v1/payments/" . $request['data']['id'] . "?access_token=" . $this->access_token;

        $paymentData = $this->curlCalls($paymentUrl);

        $payment = json_decode($paymentData, true);



        if ($payment['status'] == 'approved') {
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


            Session::forget('order_data');
            Session::forget('cart');

            return redirect($success_url);
        }

        return redirect($cancel_url);
    }
}
