<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Testimonial;
use App\BasicSetting as BS;
use Validator;
use Session;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['testimonials'] = Testimonial::where('language_id', $data['lang_id'])->orderBy('id', 'DESC')->get();

        return view('admin.home.testimonial.index', $data);
    }

    public function edit($id)
    {
        $data['testimonial'] = Testimonial::findOrFail($id);
        return view('admin.home.testimonial.edit', $data);
    }

    public function upload(Request $request)
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'testimonial']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('testimonial_image', $filename);
        $request->file('file')->move('assets/front/img/testimonials/', $filename);
        return response()->json(['status' => "session_put", "image" => "testimonial_image", 'filename' => $filename]);
    }

    public function uploadUpdate(Request $request, $id)
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'testimonial']);
        }

        $testimonial = Testimonial::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/testimonials/', $filename);
            @unlink('assets/front/img/testimonials/' . $testimonial->image);
            $testimonial->image = $filename;
            $testimonial->save();
        }

        return response()->json(['status' => "success", "image" => "Testimonial", 'testimonial' => $testimonial]);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'testimonial_image' => 'required',
            'comment' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $testimonial = new Testimonial;
        $testimonial->language_id = $request->language_id;
        $testimonial->comment = $request->comment;
        $testimonial->name = $request->name;
        $testimonial->rank = $request->rank;
        $testimonial->image = $request->testimonial_image;
        $testimonial->serial_number = $request->serial_number;
        $testimonial->save();

        Session::flash('success', 'Testimonial added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'comment' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $testimonial = Testimonial::findOrFail($request->testimonial_id);
        $testimonial->comment = $request->comment;
        $testimonial->name = $request->name;
        $testimonial->rank = $request->rank;
        $testimonial->serial_number = $request->serial_number;
        $testimonial->save();

        Session::flash('success', 'Testimonial updated successfully!');
        return "success";
    }

    public function textupdate(Request $request, $langid)
    {
        $request->validate([
            'testimonial_section_title' => 'required|max:25',
            'testimonial_section_subtitle' => 'required|max:80',
        ]);

        $bs = BS::where('language_id', $langid)->firstOrFail();
        $bs->testimonial_title = $request->testimonial_section_title;
        $bs->testimonial_subtitle = $request->testimonial_section_subtitle;
        $bs->save();

        Session::flash('success', 'Text updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $testimonial = Testimonial::findOrFail($request->testimonial_id);
        @unlink('assets/front/img/testimonials/' . $testimonial->image);
        $testimonial->delete();

        Session::flash('success', 'Testimonial deleted successfully!');
        return back();
    }
}
