<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;
use App\User;
use Auth;
use Validator;
use Session;
use App\Language;
use DB;
use App;
use Config;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\BasicExtra;

class RegisterController extends Controller
{

    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();

        Config::set('captcha.sitekey', $bs->google_recaptcha_site_key);
        Config::set('captcha.secret', $bs->google_recaptcha_secret_key);
    }

    public function registerPage()
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

        return view('front.register', $data);

    }

    public function register(Request $request)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'email'   => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed'
        ];

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

            $user = new User;
            $input = $request->all();
            $input['status'] = 1;
            $input['password'] = bcrypt($request['password']);
            $token = md5(time().$request->name.$request->email);
            $input['verification_link'] = $token;
            $user->fill($input)->save();


                // Send Mail to Buyer
       $mail = new PHPMailer(true);
    //    $user = Auth::user();

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
               $mail->addAddress($request->email, $request->username);

               // Content
               $mail->isHTML(true);

               $mail->Subject = "Verify your email address.";
               $mail->Body    = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('register/verify/'.$token).">Simply click here to verify. </a>";
               $mail->send();

               return back()->with('sendmail','A verifican mail has been sent to your email address.');

           } catch (Exception $e) {
               // die($e->getMessage());
           }
       } else {
           try {

               //Recipients
               $mail->setFrom($be->from_mail, $be->from_name);
               $mail->addAddress($request->email, $request->username);

               // Content
               $mail->isHTML(true);
               $mail->Subject = "Verify your email address.";
               $mail->Body    = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('register/verify/'.$token).">Simply click here to verify. </a>";

               $mail->send();
           } catch (Exception $e) {
               // die($e->getMessage());
           }

           return back()->with('sendmail','We need to verify your email address. We have sent an email to  '.$request->email. ' to verify your email address. Please click link in that email to continue.');
            }

        }


        public function token($token)
    {
            $user = User::where('verification_link',$token)->first();
            if(isset($user))
            {
                $user->email_verified = 'Yes';
                $user->update();
                Auth::guard('web')->login($user);
                Session::flash('success', 'Email Verified Successfully');
                return redirect()->route('user-dashboard');
            }
    }

}
