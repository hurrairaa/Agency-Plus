<?php

namespace App\Http\Controllers\Payment\product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mollie\Laravel\Facades\Mollie;
use App\Language;
use App\OfflineGateway;
use App\OrderItem;
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

class MollieController extends Controller
{
    public function store(Request $request)
    {
        if (!Session::has('cart')) {
            return view('errors.404');
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

        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $bex = $currentLang->basic_extra;

        $available_currency = array('AED', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'ILS', 'ISK', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TWD', 'USD', 'ZAR');


        if (!in_array($bex->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', __('Invalid Currency For Mollie Payment.'));
        }

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
        // Validation Ends



        // saving datas in database
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
        $order->method = "Mollie Payment";
        $order->currency_code = $bex->base_currency_text;
        $order->order_number = str_random(4) . time();
        $order->payment_status = 'Pending';
        $order['txnid'] = 'txn_' . str_random(8) . time();
        $order['charge_id'] = 'ch_' . str_random(9) . time();
        if ($request->hasFile('receipt')) {
            $receipt = uniqid() . '.' . $request->file('receipt')->getClientOriginalExtension();
            $request->file('receipt')->move('assets/front/receipt/', $receipt);
            $order['receipt'] = $receipt;
        }


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
        // saving datas in database


        $orderData['item_name'] = $bs->website_title . " Order";
        $orderData['item_number'] = str_random(4) . time();
        $orderData['item_amount'] = $total;
        $orderData['order_id'] = $order_id;
        $orderData['invoice'] = $fileName;
        $notify_url = route('product.mollie.notify');

        // dd($currencies);
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => $bex->base_currency_text,
                'value' => '' . sprintf('%0.2f', $orderData['item_amount']) . '', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => $orderData['item_name'],
            'redirectUrl' => $notify_url,
        ]);

        /** add payment ID to session **/
        Session::put('order_data', $orderData);
        Session::put('order_payment_id', $payment->id);

        $payment = Mollie::api()->payments()->get($payment->id);

        return redirect($payment->getCheckoutUrl(), 303);
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

        $payment = Mollie::api()->payments()->get(Session::get('order_payment_id'));
        if ($payment->status == 'paid') {
            // dd($orderid);
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
            Session::forget('order_payment_id');
            Session::forget('cart');

            return redirect($success_url);
        }
        return redirect($cancel_url);
    }
}
