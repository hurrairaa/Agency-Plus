<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Mail\ForgetMail;
use Mail;
use Session;

class ForgetController extends Controller
{
    public function mailForm() {
        return view('admin.forget');
    }

    public function sendmail(Request $request) {
        // check whether the mail exists in database
        $request->validate([
            'email' => [
                'required',
                function ($attribute, $value, $fail) {
                    $count = Admin::where('email', $value)->count();
                    if ($count == 0) {
                        $fail("The email address doesn't exist");
                    }
                }
            ]
        ]);

        // change the password with newly created random password
        $pass = uniqid();
        $admin = Admin::where('email', $request->email)->first();
        $admin->password = bcrypt($pass);
        $admin->save();

        // send the random (newly created) & username to the mail
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $from = $bs->contact_mail;
        $to = $request->email;
        $subject = "Restore Password & Username";
        Mail::to($to)->send(new ForgetMail($from, $subject, $pass, $admin->username));

        Session::flash('success', 'New password & current username sent successfully via mail');
        return back();
    }
}
