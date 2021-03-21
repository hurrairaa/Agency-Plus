<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\Language;
use Validator;
use Session;

class ServicesectionController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;

        return view('admin.home.service-section', $data);
    }

    public function update(Request $request, $langid)
    {
        $rules = [
            'service_section_subtitle' => 'required|max:80',
            'service_section_title' => 'required|max:25'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->service_section_subtitle = $request->service_section_subtitle;
        $bs->service_section_title = $request->service_section_title;
        $bs->save();

        Session::flash('success', 'Texts updated successfully!');
        return "success";
    }
}
