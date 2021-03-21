<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\Point;
use App\Language;
use Session;
use Validator;

class ApproachController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['points'] = Point::where('language_id', $data['lang_id'])->orderBy('id', 'DESC')->get();

        return view('admin.home.approach.index', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'title' => 'required',
            'short_text' => 'required',
            'serial_number' => 'required|integer',
        ];

        $be = BasicExtended::first();
        $version = getVersion($be->theme_version);

        if ($version == 'cleaning') {
            $rules['color'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $point = new Point;
        $point->language_id = $request->language_id;
        $point->icon = $request->icon;
        if ($version == 'cleaning') {
            $point->color = $request->color;
        }
        $point->title = $request->title;
        $point->short_text = $request->short_text;
        $point->serial_number = $request->serial_number;
        $point->save();

        Session::flash('success', 'New point added successfully!');
        return "success";
    }

    public function pointedit($id)
    {
        $data['point'] = Point::findOrFail($id);
        return view('admin.home.approach.edit', $data);
    }

    public function update(Request $request, $langid)
    {
        $request->validate([
            'approach_section_title' => 'required|max:25',
            'approach_section_subtitle' => 'required|max:80',
            'approach_section_button_text' => 'nullable|max:15',
            'approach_section_button_url' => 'nullable|max:255',
        ]);

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->approach_title = $request->approach_section_title;
        $bs->approach_subtitle = $request->approach_section_subtitle;
        $bs->approach_button_text = $request->approach_section_button_text;
        $bs->approach_button_url = $request->approach_section_button_url;
        $bs->save();

        Session::flash('success', 'Text updated successfully!');
        return back();
    }

    public function pointupdate(Request $request)
    {
        $rules = [
            'title' => 'required',
            'short_text' => 'required',
            'serial_number' => 'required|integer',
        ];

        $be = BasicExtended::first();
        $version = getVersion($be->theme_version);

        if ($version == 'cleaning') {
            $rules['color'] = 'required';
        }

        $request->validate($rules);

        $point = Point::findOrFail($request->pointid);
        $point->icon = $request->icon;
        if ($version == 'cleaning') {
            $point->color = $request->color;
        }
        $point->title = $request->title;
        $point->short_text = $request->short_text;
        $point->serial_number = $request->serial_number;
        $point->save();

        Session::flash('success', 'Point updated successfully!');
        return back();
    }

    public function pointdelete(Request $request)
    {

        $point = Point::findOrFail($request->pointid);
        $point->delete();

        Session::flash('success', 'Point deleted successfully!');
        return back();
    }
}
