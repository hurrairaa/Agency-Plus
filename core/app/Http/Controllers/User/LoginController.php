<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Language;
use Validator;
use DB;
use App;
use Config;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\BasicExtra;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
        $bs = BS::first();
        $be = BE::first();

        Config::set('captcha.sitekey', $bs->google_recaptcha_site_key);
        Config::set('captcha.secret', $bs->google_recaptcha_secret_key);
    }

    public function showLoginForm()
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

        $url = url()->previous();
        $url = (explode('/', $url));
        if (in_array('checkout', $url)) {
            session(['link' => url()->previous()]);
        }

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.login', $data);
    }

    public function login(Request $request)
    {

        if (Session::has('link')) {
            $redirectUrl = Session::get('link');
            Session::forget('link');
        } else {
            $redirectUrl = route('user-dashboard');
        }

        //--- Validation Section
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;



        $rules = [
            'email'   => 'required|email',
            'password' => 'required'
        ];

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];
        $request->validate($rules, $messages);
        //--- Validation Section Ends

        // Attempt to log the user in
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // if successful, then redirect to their intended location

            // Check If Email is verified or not
            if (Auth::guard('web')->user()->email_verified == 'no' || Auth::guard('web')->user()->email_verified == 'No') {
                Auth::guard('web')->logout();

                return back()->with('err', __('Your Email is not Verified!'));
            }
            if (Auth::guard('web')->user()->status == '0') {
                Auth::guard('web')->logout();

                return back()->with('err', __('Your account has been banned'));
            }
            return redirect($redirectUrl);
        }
        // if unsuccessful, then redirect back to the login with the form data
        return back()->with('err', __("Credentials Doesn\'t Match !"));
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
