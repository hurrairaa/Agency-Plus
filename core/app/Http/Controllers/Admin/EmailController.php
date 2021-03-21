<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class EmailController extends Controller
{
    public function mailFromAdmin() {
        $data['abe'] = BasicExtended::first();
        return view('admin.basic.email.mail_from_admin', $data);
    }

    public function updateMailFromAdmin(Request $request) {
        $messages = [
            'from_mail.required_if' => 'The smtp host field is required when smtp status is active.',
            'from_name.required_if' => 'The from name field is required when smtp status is active.',
            'smtp_host.required_if' => 'The smtp host field is required when smtp status is active.',
            'smtp_port.required_if' => 'The smtp port field is required when smtp status is active.',
            'encryption.required_if' => 'The encryption field is required when smtp status is active.',
            'smtp_username.required_if' => 'The smtp username field is required when smtp status is active.',
            'smtp_password.required_if' => 'The smtp password field is required when smtp status is active.'
        ];

        $request->validate([
            'from_mail' => 'required_if:is_smtp,1',
            'from_name' => 'required_if:is_smtp,1',
            'is_smtp' => 'required',
            'smtp_host' => 'required_if:is_smtp,1',
            'smtp_port' => 'required_if:is_smtp,1',
            'encryption' => 'required_if:is_smtp,1',
            'smtp_username' => 'required_if:is_smtp,1',
            'smtp_password' => 'required_if:is_smtp,1',
        ], $messages);

        $bes = BasicExtended::all();
        foreach ($bes as $key => $be) {
            $be->from_mail = $request->from_mail;
            $be->from_name = $request->from_name;
            $be->is_smtp = $request->is_smtp;
            $be->smtp_host = $request->smtp_host;
            $be->smtp_port = $request->smtp_port;
            $be->encryption = $request->encryption;
            $be->smtp_username = $request->smtp_username;
            $be->smtp_password = $request->smtp_password;
            $be->save();
        }

        Session::flash('success', 'SMTP configuration updated successfully!');
        return back();
    }

    public function mailToAdmin() {
        $data['abe'] = BasicExtended::first();
        return view('admin.basic.email.mail_to_admin', $data);
    }

    public function updateMailToAdmin(Request $request) {
        $messages = [
            'to_mail.required' => 'Mail Address is required.'
        ];

        $request->validate([
            'to_mail' => 'required',
        ], $messages);

        $bes = BasicExtended::all();
        foreach ($bes as $key => $be) {
            $be->to_mail = $request->to_mail;
            $be->save();
        }

        Session::flash('success', 'Mail address updated successfully!');
        return back();
    }
}
