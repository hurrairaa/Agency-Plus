<?php

namespace App\Http\Controllers\Payment;

use App\BasicSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use App\Mail\OrderPackage;
use App\OfflineGateway;
use App\Package;
use App\PackageInput;
use App\PackageOrder;
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

class PaypalController extends Controller
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

        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $bex = $currentLang->basic_extra;
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
            ],
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


        $package = Package::find($request->package_id);
        $packageid = $package->id;
        $input = $request->except('nda');

        $title = "Order Package <strong>" . $package->title . "</strong>";
        $price = $package->price / $bex->base_currency_rate;
        $price = round($price, 2);
        $cancel_url = route('front.payment.cancle', $packageid);
        $notify_url = route('front.paypal.notify', $packageid);


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($title)
            /** item name **/
            ->setCurrency("USD")
            ->setQuantity(1)
            ->setPrice($price);
        /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($price);
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
            return redirect()->back()->with('error', $ex->getMessage());
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        if ($request->hasFile('nda')) {
            $filename = uniqid() . '.' . $request->file('nda')->getClientOriginalExtension();
            $nda->move('assets/front/ndas/', $filename);
            session()->put('nda', $filename);
        }
        /** add payment ID to session **/
        Session::put('paypal_data', $input);
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        return redirect()->back()->with('error', 'Unknown error occurred');

        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        return redirect()->back()->with('error', 'Unknown error occurred');
    }


    public function notify(Request $request, $packageid)
    {

        $paypal_data = Session::get('paypal_data');
        $cancel_url = route('front.payment.cancle', $packageid);
        $input = $request->except('nda');
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


            if (session()->has('lang')) {
                $currentLang = Language::where('code', session()->get('lang'))->first();
            } else {
                $currentLang = Language::where('is_default', 1)->first();
            }

            $package_inputs = $currentLang->package_inputs;
            $be = $currentLang->basic_extended;

            $fields = [];
            foreach ($package_inputs as $key => $input) {
                $in_name = $input->name;
                if ($paypal_data["$in_name"]) {
                    $fields["$in_name"] = $paypal_data["$in_name"];
                }
            }
            $jsonfields = json_encode($fields);
            $jsonfields = str_replace("\/", "/", $jsonfields);

            $package = Package::findOrFail($paypal_data["package_id"]);

            $in['name'] = $paypal_data["name"];
            $in['email'] = $paypal_data["email"];
            $in['fields'] = $jsonfields;



            $in['package_title'] = $package->title;
            $in['package_price'] = $package->price;
            $in['package_description'] = $package->description;
            $in['nda'] = session()->get('nda');
            $in['method'] = 'Paypal';
            $fileName = str_random(4) . time() . '.pdf';
            $in['invoice'] = $fileName;
            $in['payment_status'] = 1;
            $po = PackageOrder::create($in);


            $po->order_number = $po->id + 1000000000;
            $po->save();


            // sending datas to view to make invoice PDF
            $fields = json_decode($po->fields, true);
            $data['packageOrder'] = $po;
            $data['fields'] = $fields;

            // generate pdf from view using dynamic datas
            PDF::loadView('pdf.package', $data)->save('assets/front/invoices/' . $fileName);

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
                    $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = "Order placed for " . $package->title;
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
                    $mail->Subject = "Order placed for " . $package->title;
                    $mail->Body    = 'Hello <strong>' . $po->name . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                    $mail->send();
                } catch (Exception $e) {
                    die($e->getMessage());
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
                $mail->Subject = "Order placed for " . $package->title;
                $mail->Body    = 'A new order has been placed.<br/><strong>Order Number: </strong>' . $po->order_number;

                $mail->send();
            } catch(\Exception $e) {
                // die($e->getMessage());
            }


            Session::forget('paypal_data');
            Session::forget('nda');

            return redirect()->route('front.packageorder.confirmation', [$package->id, $po->id]);
        }
        return redirect($cancel_url);
    }
}
