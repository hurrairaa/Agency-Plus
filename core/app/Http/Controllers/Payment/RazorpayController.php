<?php

namespace App\Http\Controllers\Payment;

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
use Razorpay\Api\Api;
use Session;
use PDF;


class RazorpayController extends Controller
{
    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('razorpay')->first();
        $paydata = $data->convertAutoData();
        $this->keyId = $paydata['key'];
        $this->keySecret = $paydata['secret'];
        $this->api = new Api($this->keyId, $this->keySecret);
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
        $be = $currentLang->basic_extended;
        $bs = $currentLang->basic_setting;
        $package_inputs = $currentLang->package_inputs;

        if ($bex->base_currency_text != "INR") {
            return redirect()->back()->with('error', __('Please Select INR Currency For This Payment.'));
        }

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
            ],
            'razorpay_phone' => 'required',
            'razorpay_address' => 'required'
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

        $input = $request->except('nda');
        $package = Package::findOrFail($request->package_id);

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
        $in['method'] = "Razorpay";
        $fileName = str_random(4) . time() . '.pdf';
        $in['invoice'] = $fileName;
        $in['payment_status'] = 0;
        $po = PackageOrder::create($in);


        $poid = $po->id;
        $po->order_number = $poid + 1000000000;
        $po->save();


        // sending datas to view to make invoice PDF
        $fields = json_decode($po->fields, true);
        $data['packageOrder'] = $po;
        $data['fields'] = $fields;

        // generate pdf from view using dynamic datas
        PDF::loadView('pdf.package', $data)->save('assets/front/invoices/' . $fileName);
        // saving datas in database


        $order['title'] = $package->title . " Order";
        $order['item_number'] = str_random(4) . time();
        $order['item_amount'] = $package->price;
        $order['package_id'] = $package->id;
        $order['order_id'] = $poid;
        $order['invoice'] = $fileName;
        $cancel_url = route('front.payment.cancle', $package->id);
        $notify_url = route('front.razorpay.notify');


        $orderData = [
            'receipt'         => $order['title'],
            'amount'          => $order['item_amount'] * 100,
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder = $this->api->order->create($orderData);

        Session::put('input_data', $input);
        Session::put('order_data', $order);
        Session::put('order_payment_id', $razorpayOrder['id']);

        $displayAmount = $amount = $orderData['amount'];

        if ($bex->base_currency_text !== 'INR') {
            $url = "https://api.fixer.io/latest?symbols=$bex->base_currency_text&base=INR";
            $exchange = json_decode(file_get_contents($url), true);

            $displayAmount = $exchange['rates'][$bex->base_currency_text] * $amount / 100;
        }

        $checkout = 'automatic';

        if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true)) {
            $checkout = $_GET['checkout'];
        }

        $data = [
            "key"               => $this->keyId,
            "amount"            => $amount,
            "name"              => $order['title'],
            "description"       => $order['title'],
            "prefill"           => [
                "name"              => $request->name,
                "email"             => $request->email,
                "contact"           => $request->razorpay_phone,
            ],
            "notes"             => [
                "address"           => $request->razorpay_address,
                "merchant_order_id" => $order['item_number'],
            ],
            "theme"             => [
                "color"             => "{{$bs->base_color}}"
            ],
            "order_id"          => $razorpayOrder['id'],
        ];

        if ($bex->base_currency_text !== 'INR') {
            $data['display_currency']  = $bex->base_currency_text;
            $data['display_amount']    = $displayAmount;
        }

        $json = json_encode($data);
        $displayCurrency = $bex->base_currency_text;

        return view('front.razorpay', compact('data', 'displayCurrency', 'json', 'notify_url'));
    }

    public function notify(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;

        $input = Session::get('input_data');
        $order_data = Session::get('order_data');
        $packageid = $order_data["package_id"];
        $orderid = $order_data["order_id"];
        $success_url = route('front.packageorder.confirmation', [$packageid, $orderid]);
        $cancel_url = route('front.payment.cancle', $packageid);
        $input_data = $request->all();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('order_payment_id');

        $success = true;

        if (empty($input_data['razorpay_payment_id']) === false) {

            try {
                $attributes = array(
                    'razorpay_order_id' => $payment_id,
                    'razorpay_payment_id' => $input_data['razorpay_payment_id'],
                    'razorpay_signature' => $input_data['razorpay_signature']
                );

                $this->api->utility->verifyPaymentSignature($attributes);
            } catch (SignatureVerificationError $e) {
                $success = false;
            }
        }

        if ($success === true) {


            // dd($orderid);
            $po = PackageOrder::findOrFail($orderid);
            $po->payment_status = 1;
            $po->save();


            // Send Mail to Buyer
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
                    $mail->addAttachment('assets/front/invoices/' . $order_data["invoice"]);         // Add attachments

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
                    $mail->addAttachment('assets/front/invoices/' . $order_data["invoice"]);         // Add attachments

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = "Order placed for " . $po->package_title;
                    $mail->Body    = 'Hello <strong>' . $request->name . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

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
                $mail->addAttachment('assets/front/invoices/' . $order_data["invoice"]);         // Add attachments

                // Content
                $mail->isHTML(true);  // Set email format to HTML
                $mail->Subject = "Order placed for " . $po->package_title;
                $mail->Body    = 'A new order has been placed.<br/><strong>Order Number: </strong>' . $po->order_number;

                $mail->send();
            } catch (\Exception $e) {
                // die($e->getMessage());
            }


            Session::forget('order_data');
            Session::forget('input_data');

            return redirect($success_url);
        }
        return redirect($cancel_url);
    }
}
