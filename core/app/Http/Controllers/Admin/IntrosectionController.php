<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\Language;
use Validator;
use Session;

class IntrosectionController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;

        return view('admin.home.intro-section', $data);
    }

    public function upload(Request $request, $langid)
    {
        // return response()->json(['status' => "success", 'method' => 'upload']);
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'intro_bg']);
        }


        if ($request->hasFile('file')) {
            $bs = BS::where('language_id', $langid)->firstOrFail();
            @unlink('assets/front/img/' . $bs->intro_bg);
            $filename = uniqid() .'.'. $img->getClientOriginalExtension();
            $img->move('assets/front/img/', $filename);

            $bs->intro_bg = $filename;
            $bs->save();

        }

        return response()->json(['status' => "success", 'image' => 'Intro section image']);
    }

    public function upload2(Request $request, $langid)
    {
        // return response()->json(['status' => "success", 'method' => 'upload2']);
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'intro_bg2']);
        }


        if ($request->hasFile('file')) {
            $be = BasicExtended::where('language_id', $langid)->firstOrFail();
            @unlink('assets/front/img/' . $be->intro_bg2);
            $filename = uniqid() .'.'. $img->getClientOriginalExtension();
            $img->move('assets/front/img/', $filename);

            $be->intro_bg2 = $filename;
            $be->save();

        }

        return response()->json(['status' => "success", 'image' => 'Intro section image']);
    }

    public function update(Request $request, $langid)
    {
        $rules = [
            'intro_section_title' => 'required|max:25',
            'intro_section_text' => 'required|max:80',
            'intro_section_button_text' => 'nullable|max:15',
            'intro_section_button_url' => 'nullable|max:255',
            'intro_section_video_link' => 'nullable'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->intro_section_title = $request->intro_section_title;
        $bs->intro_section_text = $request->intro_section_text;
        $bs->intro_section_button_text = $request->intro_section_button_text;
        $bs->intro_section_button_url = $request->intro_section_button_url;
        $videoLink = $request->intro_section_video_link;
        if (strpos($videoLink, "&") != false) {
            $videoLink = substr($videoLink, 0, strpos($videoLink, "&"));
        }
        $bs->intro_section_video_link = $videoLink;
        $bs->save();

        Session::flash('success', 'Informations updated successfully!');
        return "success";
    }
}
