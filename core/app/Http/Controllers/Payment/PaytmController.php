<?php

namespace App\Http\Controllers\Payment;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use App\OfflineGateway;
use App\Package;
use App\PackageInput;
use App\PackageOrder;
use App\PaymentGateway;
use PDF;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PaytmController extends Controller
{
    public function store(Request $request)
    {
        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }



        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $package_inputs = $currentLang->package_inputs;

        $nda = $request->file('nda');
        $ndaIn = PackageInput::find(1);
        $allowedExts = array('doc', 'docx', 'pdf', 'rtf', 'txt', 'zip', 'rar');

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'package_id' => 'required',
            'nda' => [
                function ($attribute, $value, $fail) use ($nda, $allowedExts) {

                    $ext = $nda->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only doc, docx, pdf, rtf, txt, zip, rar files are allowed");
                    }
                }
            ]
        ];

        if ($ndaIn->required == 1 && $ndaIn->active == 1) {
            if (!$request->hasFile('nda')) {
                $rules["nda"] = 'required';
            }
        }

        foreach ($package_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"] = 'required';
            }
        }

        $conline  = PaymentGateway::whereStatus(1)->whereType('automatic')->count();
        $coffline  = OfflineGateway::wherePackageOrderStatus(1)->count();
        if ($conline + $coffline > 0) {
            $rules["method"] = 'required';
        }

        $request->validate($rules);
        // Validation Ends

        $bex = $currentLang->basic_extra;
        if ($bex->base_currency_text != "INR") {
            return redirect()->back()->with('error', 'Please Select INR Currency For Paytm.');
        }

        $package = Package::find($request->package_id);




        $fields = [];
        foreach ($package_inputs as $key => $input) {
            $in_name = $input->name;
            if ($request["$in_name"]) {
                $fields["$in_name"] = $request["$in_name"];
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/", "/", $jsonfields);

        $in = $request->all();
        $in['name'] = $request->name;
        $in['email'] = $request->email;
        $in['fields'] = $jsonfields;

        if ($request->hasFile('nda')) {
            $filename = uniqid() . '.' . $nda->getClientOriginalExtension();
            $nda->move('assets/front/ndas/', $filename);
            $in['nda'] = $filename;
        }

        $in['package_title'] = $package->title;
        $in['package_price'] = $package->price;
        $in['package_description'] = $package->description;
        $in['method'] = 'Paytm';
        $po = PackageOrder::create($in);
        $poid = $po->id;


        $po->order_number = $poid + 1000000000;
        $po->save();

        $item_number = $poid;
        $item_amount = $package->price;


        Session::put('item_number', $item_number);
        Session::put('package_id', $package->id);
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
        $paramList["CALLBACK_URL"] = route('front.paytm.notify');

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
        if ('TXN_SUCCESS' === $request['STATUS']) {
            $po = PackageOrder::findOrFail(Session::get('item_number'));

            $data['payment_status'] = 1;
            $fileName = str_random(4).time().'.pdf';
            $data['invoice'] = $fileName;
            $po->update($data);

            // sending datas to view to make invoice PDF
            $fields = json_decode($po->fields, true);
            $data['packageOrder'] = $po;
            $data['fields'] = $fields;

            // generate pdf from view using dynamic datas
            PDF::loadView('pdf.package', $data)->save('assets/front/invoices/' . $fileName);


            // Send Mail to Buyer
            if (session()->has('lang')) {
                $currentLang = Language::where('code', session()->get('lang'))->first();
            } else {
                $currentLang = Language::where('is_default', 1)->first();
            }

            $be = $currentLang->basic_extended;

            $mail = new PHPMailer(true);


            if ($be->is_smtp == 1) {
                try {
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = $be->smtp_username;                     // SMTP username
                    $mail->Password   = $be->smtp_password;                               // SMTP password
                    $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom($be->from_mail, $be->from_name);
                    $mail->addAddress($po->email, $po->name);     // Add a recipient

                    // Attachments
                    $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = "Order placed for " . $po->package_title;
                    $mail->Body    = 'Hello <strong>' . $po->name . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                    $mail->send();
                } catch (Exception $e) {
                    // die($e->getMessage());
                }
            } else {
                try {

                    //Recipients
                    $mail->setFrom($be->from_mail, $be->from_name);
                    $mail->addAddress($po->email, $po->name);     // Add a recipient

                    // Attachments
                    $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = "Order placed for " . $po->package_title;
                    $mail->Body    = 'Hello <strong>' . $po->name . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                    $mail->send();
                } catch (Exception $e) {
                    // die($e->getMessage());
                }
            }


            // send mail to Admin
            try {

                $mail = new PHPMailer(true);
                $mail->setFrom($po->email, $po->name);
                $mail->addAddress($be->from_mail);     // Add a recipient

                // Attachments
                $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                // Content
                $mail->isHTML(true);  // Set email format to HTML
                $mail->Subject = "Order placed for " . $po->package_title;
                $mail->Body    = 'A new order has been placed.<br/><strong>Order Number: </strong>' . $po->order_number;

                $mail->send();
            } catch (\Exception $e) {
                // die($e->getMessage());
            }

            session()->flash('success', 'Payment completed!');
            return redirect()->route('front.packageorder.confirmation', [Session::get('package_id'), $po->id]);
        } else if ('TXN_FAILURE' === $request['STATUS']) {
            //return view( 'payment-failed' );
            $po = PackageOrder::findOrFail(Session::get('item_number'));
            $po->delete();

            session()->flash('error', 'Something is wrong!');
            return redirect(route('front.payment.cancle', Session::get('package_id')));
        }


    }
}
