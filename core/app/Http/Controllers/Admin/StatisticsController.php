<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\Statistic;
use App\Language;
use Session;
use Validator;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['statistics'] = Statistic::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;
        $data['abe'] = $lang->basic_extended;
        $data['selLang'] = Language::where('code', $request->language)->first();

        return view('admin.home.statistics.index', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $count = Statistic::where('language_id', $request->language_id)->count();
        if ($count == 4) {
            Session::flash('warning', 'You cannot add more than 4 statistics!');
            return "success";
        }

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:20',
            'quantity' => 'required|integer',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $statistic = new Statistic;
        $statistic->language_id = $request->language_id;
        $statistic->icon = $request->icon;
        $statistic->title = $request->title;
        $statistic->quantity = $request->quantity;
        $statistic->serial_number = $request->serial_number;
        $statistic->save();

        Session::flash('success', 'New statistic added successfully!');
        return "success";
    }

    public function edit($id)
    {
        $data['statistic'] = Statistic::findOrFail($id);
        if (!empty($data['statistic']->language)) {
            $data['selLang'] = $data['statistic']->language;
        }

        return view('admin.home.statistics.edit', $data);
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:20',
            'quantity' => 'required|integer',
            'serial_number' => 'required|integer',
        ];

        $request->validate($rules);

        $statistic = Statistic::findOrFail($request->statisticid);
        $statistic->icon = $request->icon;
        $statistic->title = $request->title;
        $statistic->quantity = $request->quantity;
        $statistic->serial_number = $request->serial_number;
        $statistic->save();

        Session::flash('success', 'Statistic updated successfully!');
        return back();
    }

    public function upload(Request $request, $langid)
    {
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'statistics_bg']);
        }

        if ($request->hasFile('file')) {
            $be = BasicExtended::where('language_id', $langid)->firstOrFail();
            @unlink('assets/front/img/' . $be->statistics_bg);
            $filename = uniqid() .'.'. $img->getClientOriginalExtension();
            $img->move('assets/front/img/', $filename);

            $be->statistics_bg = $filename;
            $be->save();

        }

        return response()->json(['status' => "success", 'image' => 'Statistics section background image']);
    }

    public function delete(Request $request)
    {

        $statistic = Statistic::findOrFail($request->statisticid);
        $statistic->delete();

        Session::flash('success', 'Statistic deleted successfully!');
        return back();
    }
}
