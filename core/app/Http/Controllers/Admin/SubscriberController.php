<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscriber;
use App\BasicSetting;
use App\Mail\ContactMail;
use Session;
use Mail;

class SubscriberController extends Controller
{
    public function index() {
      $data['subscs'] = Subscriber::orderBy('id', 'DESC')->get();
      return view('admin.subscribers.index', $data);
    }

    public function mailsubscriber() {
      return view('admin.subscribers.mail');
    }

    public function subscsendmail(Request $request) {
      $request->validate([
        'subject' => 'required',
        'message' => 'required'
      ]);

      $sub = $request->subject;
      $msg = $request->message;

      $subscs = Subscriber::all();
      $settings = BasicSetting::first();
      $from = $settings->contact_mail;


      Mail::to($subscs)->send(new ContactMail($from, $sub, $msg, true));

      Session::flash('success', 'Mail sent successfully!');
      return back();
    }
}
