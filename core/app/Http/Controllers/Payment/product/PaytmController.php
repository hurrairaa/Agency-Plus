<?php

namespace App\Http\Controllers\Payment\product;

use App\BasicExtended;
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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PDF;

class PaytmController extends Controller
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
        $be = $currentLang->basic_extended;
        $bex = $currentLang->basic_extra;

        $bex = $currentLang->basic_extra;
        if ($bex->base_currency_text != "INR") {
            return redirect()->back()->with('error', 'Please Select INR Currency For Paytm.');
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
        $order->method = "Paytm";
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

        $item_number = $order_id;
        $item_amount = $total;


        Session::put('item_number', $item_number);
        Session::put('order_id', $order_id);
        Session::put('invoice', $fileName);
        $data_for_request = $this->handlePaytmRequest($item_number, $item_amount);
        $paytm_txn_url = 'https://securegw-stage.paytm.in/theia/processTransaction';
        $paramList = $data_for_request['paramList'];
        $checkSum = $data_for_request['checkSum'];

        $be = BasicExtended::first();
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        return view('front.paytm', compact('paytm_txn_url', 'paramList', 'checkSum', 'version'));
    }

    public function handlePaytmRequest($order_id, $amount)
    {
        $data = PaymentGateway::whereKeyword('paytm')->first();
        $paydata = $data->convertAutoData();

        // Load all functions of encdec_paytm.php and config-paytm.php
        $this->getAllEncdecFunc();
        // $this->getConfigPaytmSettings();
        $checkSum = "";
        $paramList = array();
        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = $paydata['merchant'];
        $paramList["ORDER_ID"] = $order_id;
        $paramList["CUST_ID"] = $order_id;
        $paramList["INDUSTRY_TYPE_ID"] = $paydata['industry'];
        $paramList["CHANNEL_ID"] = 'WEB';
        $paramList["TXN_AMOUNT"] = $amount;
        $paramList["WEBSITE"] = $paydata['website'];
        $paramList["CALLBACK_URL"] = route('product.paytm.notify');

        $paytm_merchant_key = $paydata['secret'];
        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray($paramList, $paytm_merchant_key);
        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }

    function getAllEncdecFunc()
    {
        function encrypt_e($input, $ky)
        {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_encrypt($input, "AES-128-CBC", $key, 0, $iv);
            return $data;
        }
        function decrypt_e($crypt, $ky)
        {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_decrypt($crypt, "AES-128-CBC", $key, 0, $iv);
            return $data;
        }
        function pkcs5_pad_e($text, $blocksize)
        {
            $pad = $blocksize - (strlen($text) % $blocksize);
            return $text . str_repeat(chr($pad), $pad);
        }
        function pkcs5_unpad_e($text)
        {
            $pad = ord($text[
                strlen($text) - 1]);
            if ($pad > strlen($text))
                return false;
            return substr($text, 0, -1 * $pad);
        }
        function generateSalt_e($length)
        {
            $random = "";
            srand((float) microtime() * 1000000);
            $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
            $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
            $data .= "0FGH45OP89";
            for ($i = 0; $i < $length; $i++) {
                $random .= substr($data, (rand() % (strlen($data))), 1);
            }
            return $random;
        }
        function checkString_e($value)
        {
            if ($value == 'null')
                $value = '';
            return $value;
        }
        function getChecksumFromArray($arrayList, $key, $sort = 1)
        {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getChecksumFromString($str, $key)
        {
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function verifychecksum_e($arrayList, $key, $checksumvalue)
        {
            $arrayList = removeCheckSumParam($arrayList);
            ksort($arrayList);
            $str = getArray2StrForVerify($arrayList);
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);
            $finalString = $str . "|" . $salt;
            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;
            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }
        function verifychecksum_eFromStr($str, $key, $checksumvalue)
        {
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);
            $finalString = $str . "|" . $salt;
            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;
            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }
        function getArray2Str($arrayList)
        {
            $findme   = 'REFUND';
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pos = strpos($value, $findme);
                $pospipe = strpos($value, $findmepipe);
                if ($pos !== false || $pospipe !== false) {
                    continue;
                }
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        function getArray2StrForVerify($arrayList)
        {
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        function redirect2PG($paramList, $key)
        {
            $hashString = getchecksumFromArray($paramList, $key);
            $checksum = encrypt_e($hashString, $key);
        }
        function removeCheckSumParam($arrayList)
        {
            if (isset($arrayList["CHECKSUMHASH"])) {
                unset($arrayList["CHECKSUMHASH"]);
            }
            return $arrayList;
        }
        function getTxnStatus($requestParamList)
        {
            return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
        }
        function getTxnStatusNew($requestParamList)
        {
            return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
        }
        function initiateTxnRefund($requestParamList)
        {
            $CHECKSUM = getRefundChecksumFromArray($requestParamList, PAYTM_MERCHANT_KEY, 0);
            $requestParamList["CHECKSUM"] = $CHECKSUM;
            return callAPI(PAYTM_REFUND_URL, $requestParamList);
        }
        function callAPI($apiURL, $requestParamList)
        {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData = json_encode($requestParamList);
            $postData = 'JsonData=' . urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData)
                )
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse, true);
            return $responseParamList;
        }
        function callNewAPI($apiURL, $requestParamList)
        {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData = json_encode($requestParamList);
            $postData = 'JsonData=' . urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData)
                )
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse, true);
            return $responseParamList;
        }
        function getRefundChecksumFromArray($arrayList, $key, $sort = 1)
        {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getRefundArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getRefundArray2Str($arrayList)
        {
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pospipe = strpos($value, $findmepipe);
                if ($pospipe !== false) {
                    continue;
                }
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        function callRefundAPI($refundApiURL, $requestParamList)
        {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData = json_encode($requestParamList);
            $postData = 'JsonData=' . urlencode($JsonData);
            $ch = curl_init($refundApiURL);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $refundApiURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse, true);
            return $responseParamList;
        }
    }

    public function notify(Request $request)
    {
        // Send Mail to Buyer
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;

        if ('TXN_SUCCESS' === $request['STATUS']) {
            $orderid = Session::get('order_id');
            $po = ProductOrder::findOrFail($orderid);
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
                            $mail->addAttachment('assets/front/invoices/product/' . Session::get("invoice"));

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
                            $mail->addAttachment('assets/front/invoices/product/' . Session::get("invoice"));

                            // Content
                            $mail->isHTML(true);
                            $mail->Subject = "Order placed for Product";
                            $mail->Body    = 'Hello <strong>' . $user->fname . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                            $mail->send();
                        } catch (Exception $e) {
                            // die($e->getMessage());
                        }
                    }

            Session::forget('invoice');
            Session::forget('order_id');
            Session::forget('cart');

            session()->flash('success', 'Payment completed!');
            return redirect()->route('product.payment.return');
        } else if ('TXN_FAILURE' === $request['STATUS']) {
            //return view( 'payment-failed' );
            $po = PackageOrder::findOrFail(Session::get('item_number'));
            $po->delete();

            session()->flash('error', 'Something is wrong!');
            return redirect(route('product.payment.cancle'));
        }


    }
}
