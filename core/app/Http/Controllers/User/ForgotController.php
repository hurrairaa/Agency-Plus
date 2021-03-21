<?php

namespace App\Http\Controllers\User;


use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use App\BasicSetting;
use Validator;
use Mail;
use Session;
use DB;
use App;
use App\BasicExtra;
use Str;


class ForgotController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showForgotForm()
    {
        $bex = BasicExtra::first();

        if ($bex->is_user_panel == 0) {
            return back();
        }

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

        return view('front.forgot', $data);

    }

    public function forgot(Request $request)
    {

        $request->validate([
            'email' => 'required'
        ]);
        // Validation Starts
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $input =  $request->all();
        $be = $currentLang->basic_extended;

        if (User::where('email', '=', $request->email)->count() > 0) {
            // user found
            $admin = User::where('email', '=', $request->email)->firstOrFail();
            $autopass = Str::random(8);
            $input['password'] = bcrypt($autopass);
            $admin->update($input);
            $subject = __("Reset Password Request");
            $msg = __("Your New Password is : ") . $autopass;

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
                    $mail->addAddress($request->email);     // Add a recipient

                    // Add attachments

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject =  $subject;
                    $mail->Body    = $msg;
                    $mail->send();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                try {
                    //Recipients
                    $mail->setFrom($be->from_mail, $be->from_name);
                    $mail->addAddress($request->email);     // Add a recipient
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject =  $subject;
                    $mail->Body    = $msg;
                    $mail->send();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }

            Session::flash('success', 'Your Password Reseted Successfully. Please Check your email for new Password.');
            return back();
        } else {

            // user not found
            Session::flash('err', 'No Account Found With This Email.');
            return back();
        }
    }
}
