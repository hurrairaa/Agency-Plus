<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting;
use App\Language;
use Session;
use Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->language)) {
            $data['lang_id'] = 0;
            $data['abs'] = BasicSetting::firstOrFail();
            $data['abe'] = BasicExtended::firstOrFail();
        } else {
            $lang = Language::where('code', $request->language)->firstOrFail();
            $data['lang_id'] = $lang->id;
            $data['abs'] = $lang->basic_setting;
            $data['abe'] = $lang->basic_extended;
        }
        return view('admin.contact', $data);
    }

    public function update(Request $request, $langid)
    {
        $request->validate([
            'contact_form_title' => 'required|max:255',
            'contact_form_subtitle' => 'required|max:255',
            'contact_address' => 'required|max:255',
            'contact_number' => 'required|max:255',
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
        ]);

        $bs = BasicSetting::where('language_id', $langid)->firstOrFail();
        $bs->contact_form_title = $request->contact_form_title;
        $bs->contact_form_subtitle = $request->contact_form_subtitle;
        $bs->contact_address = $request->contact_address;
        $bs->contact_number = $request->contact_number;
        $bs->latitude = $request->latitude;
        $bs->longitude = $request->longitude;
        $bs->save();

        Session::flash('success', 'Contact page updated successfully!');
        return back();
    }
}
