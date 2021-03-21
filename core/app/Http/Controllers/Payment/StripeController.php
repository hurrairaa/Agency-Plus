<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Support\Facades\Mail;
use App\Language;
use App\Mail\OrderPackage;
use App\OfflineGateway;
use App\Package;
use App\PackageInput;
use App\PackageOrder;
use App\PaymentGateway;
use Config;
use PDF;

class StripeController extends Controller
{
    public function __construct()
    {
        //Set Spripe Keys
        $stripe = PaymentGateway::findOrFail(14);
        $stripeConf = json_decode($stripe->information, true);
        Config::set('services.stripe.key', $stripeConf["key"]);
        Config::set('services.stripe.secret', $stripeConf["secret"]);
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
        $be = $currentLang->basic_extended;
        $bex = $currentLang->basic_extra;
        $package_inputs = $currentLang->package_inputs;

        $nda = $request->file('nda');
        $ndaIn = PackageInput::find(1);
        $allowedExts = array('doc', 'docx', 'pdf', 'rtf', 'txt', 'zip', 'rar');

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'package_id' => 'required',
            'cardNumber' => 'required',
            'cardCVC' => 'required',
            'month' => 'required',
            'year' => 'required',
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
        $title = $package->title;


        $stripe = Stripe::make(Config::get('services.stripe.secret'));
        try {

            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $request->cardNumber,
                    'exp_month' => $request->month,
                    'exp_year' => $request->year,
                    'cvc' => $request->cardCVC,
                ],
            ]);

            if (!isset($token['id'])) {
                return back()->with('error', 'Token Problem With Your Token.');
            }

            $charge = $stripe->charges()->create([
                'card' => $token['id'],
                'currency' =>  "USD",
                'amount' => round(($package->price / $bex->base_currency_rate), 2),
                'description' => $title,
            ]);


            // donar data store..............//

            if ($charge['status'] == 'succeeded') {
                $fields = [];
                foreach ($package_inputs as $key => $input) {
                    $in_name = $input->name;
                    if ($request["$in_name"]) {
                        $fields["$in_name"] = $request["$in_name"];
                    }
                }
                $jsonfields = json_encode($fields);
                $jsonfields = str_replace("\/", "/", $jsonfields);

                $package = Package::findOrFail($request->package_id);

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
                $in['package_currency'] = $package->currency;
                $in['package_price'] = $package->price;
                $in['package_description'] = $package->description;
                $in['method'] = 'Stripe';
                $fileName = str_random(4).time().'.pdf';
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
                        $mail->addAddress($request->email, $request->name);     // Add a recipient

                        // Attachments
                        $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = "Order placed for " . $package->title;
                        $mail->Body    = 'Hello <strong>' . $request->name . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                        $mail->send();
                    } catch (Exception $e) {
                        // die($e->getMessage());
                    }
                } else {
                    try {

                        //Recipients
                        $mail->setFrom($be->from_mail, $be->from_name);
                        $mail->addAddress($request->email, $request->name);     // Add a recipient

                        // Attachments
                        $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = "Order placed for " . $package->title;
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
                    $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                    // Content
                    $mail->isHTML(true);  // Set email format to HTML
                    $mail->Subject = "Order placed for " . $package->title;
                    $mail->Body    = 'A new order has been placed.<br/><strong>Order Number: </strong>' . $po->order_number;

                    $mail->send();
                } catch(\Exception $e) {
                    // die($e->getMessage());
                }

                session()->flash('success', 'Payment completed!');
                return redirect()->route('front.packageorder.confirmation', [$package->id, $po->id]);
            }
        } catch (Exception $e) {
            return back()->with('unsuccess', $e->getMessage());
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return back()->with('unsuccess', $e->getMessage());
        } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            return back()->with('unsuccess', $e->getMessage());
        }
        return back()->with('unsuccess', 'Please Enter Valid Credit Card Informations.');
    }
}
