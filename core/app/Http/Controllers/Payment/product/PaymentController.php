<?php

namespace App\Http\Controllers\Payment\product;

use App\BasicSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use App\ProductOrder;
use App\OrderItem;
use App\Product;
use App\ShippingCharge;
use Carbon\Carbon;
use App\PaymentGateway;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use Mail;
use PDF;
use Auth;


class PaymentController extends Controller
{

    private $_api_context;
    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('paypal')->first();
        $paydata = $data->convertAutoData();
        $paypal_conf = \Config::get('paypal');
        $paypal_conf['client_id'] = $paydata['client_id'];
        $paypal_conf['secret'] = $paydata['client_secret'];
        $paypal_conf['settings']['mode'] = $paydata['sandbox_check'] == 1 ? 'sandbox' : 'live';
        $this->_api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret']
            )
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

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



        $request->validate([
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
            'shpping_email' => 'required',
        ]);

        $input = $request->all();

        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extra;

        $title = 'Product Checkout';

        $order['order_number'] = str_random(4) . time();

        $order['order_amount'] = round($total, 2);
        $cancel_url = action('Payment\product\PaymentController@paycancle');
        $notify_url = route('product.payment.notify');
        $success_url = action('Payment\product\PaymentController@payreturn');


        $total = round(($total / $bex->base_currency_rate), 2);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($title)
            /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice(round($total, 2));
        /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal(round($total, 2));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($title . ' Via Paypal');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl($notify_url)
            /** Specify return URL **/
            ->setCancelUrl($cancel_url);
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            return redirect()->back()->with('unsuccess', $ex->getMessage());
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_data', $input);
        Session::put('order_data', $order);
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        return redirect()->back()->with('unsuccess', 'Unknown error occurred');

        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        return redirect()->back()->with('unsuccess', 'Unknown error occurred');
    }

    public function paycancle()
    {
        return redirect()->back()->with('unsuccess', 'Payment Cancelled.');
    }

    public function payreturn()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.product.success', $data);
    }


    public function notify(Request $request)
    {


        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extra;
        $be = $currentLang->basic_extended;


        $paypal_data = Session::get('paypal_data');


        $order_data = Session::get('order_data');
        $success_url = action('Payment\product\PaymentController@payreturn');
        $cancel_url = action('Payment\product\PaymentController@paycancle');
        $input = $request->all();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        if (empty($input['PayerID']) || empty($input['token'])) {
            return redirect($cancel_url);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($input['PayerID']);
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $resp = json_decode($payment, true);


            $cart = Session::get('cart');

            $total = 0;
            foreach ($cart as $id => $item) {
                $product = Product::findOrFail($id);
                if ($product->stock < $item['qty']) {
                    Session::flash('error', $product->title . ' stock not available');
                    return back();
                }
                $total  += $product->current_price * $item['qty'];
            }

            if ($paypal_data['shipping_charge'] != 0) {
                $shipping = ShippingCharge::findOrFail($paypal_data['shipping_charge']);
                $shippig_charge = $shipping->charge;
            } else {
                $shippig_charge = 0;
            }

            $total = round($total + $shippig_charge, 2);


            $order = new ProductOrder;


            $order->billing_fname = $paypal_data['billing_fname'];
            $order->billing_lname = $paypal_data['billing_lname'];
            $order->billing_email = $paypal_data['billing_email'];
            $order->billing_address = $paypal_data['billing_address'];
            $order->billing_city = $paypal_data['billing_city'];
            $order->billing_country = $paypal_data['billing_country'];
            $order->billing_number = $paypal_data['billing_number'];
            $order->shpping_fname = $paypal_data['shpping_fname'];
            $order->shpping_lname = $paypal_data['shpping_lname'];
            $order->shpping_email = $paypal_data['shpping_email'];
            $order->shpping_address = $paypal_data['shpping_address'];
            $order->shpping_city = $paypal_data['shpping_city'];
            $order->shpping_country = $paypal_data['shpping_country'];
            $order->shpping_number = $paypal_data['shpping_number'];


            $order->total = round($order_data['order_amount'], 2);
            $order->shipping_charge = round($shippig_charge, 2);
            $order->method = $paypal_data['method'];
            $order->currency_code = $bex->base_currency_text;
            $order['order_number'] = $order_data['order_number'];
            $order['payment_status'] = "Completed";
            $order['txnid'] = $resp['transactions'][0]['related_resources'][0]['sale']['id'];
            $order['charge_id'] = $request->paymentId;
            $order['user_id'] = Auth::user()->id;
            $order['method'] = 'Paypal';

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
                    $mail->addAttachment('assets/front/invoices/product/' . $fileName);

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
                    $mail->addAttachment('assets/front/invoices/product/' . $fileName);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = "Order placed for Product";
                    $mail->Body    = 'Hello <strong>' . $user->fname . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                    $mail->send();
                } catch (Exception $e) {
                    // die($e->getMessage());
                }
            }


            Session::forget('paypal_data');
            Session::forget('order_data');
            Session::forget('paypal_payment_id');
            Session::forget('cart');

            return redirect($success_url);
        }
        return redirect($cancel_url);
    }
}
