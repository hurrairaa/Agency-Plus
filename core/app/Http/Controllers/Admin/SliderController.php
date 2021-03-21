<?php

namespace App\Http\Controllers\Admin;

use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Slider;
use App\Language;
use Validator;
use Session;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['sliders'] = Slider::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;
        return view('admin.home.hero.slider.index', $data);
    }

    public function edit($id)
    {
        $data['slider'] = Slider::findOrFail($id);
        return view('admin.home.hero.slider.edit', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'slider']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('slider_image', $filename);
        $request->file('file')->move('assets/front/img/sliders/', $filename);
        return response()->json(['status' => "session_put", "image" => "slider_image", 'filename' => $filename]);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'slider_image' => 'required',
            'title' => 'nullable',
            'title_font_size' => 'required|integer|digits_between:1,3',
            'text' => 'nullable',
            'text_font_size' => 'required|integer|digits_between:1,3',
            'button_text' => 'nullable',
            'button_text_font_size' => 'required|integer|digits_between:1,3',
            'button_url' => 'nullable|max:255',
            'serial_number' => 'required|integer',
        ];


        $be = BasicExtended::first();
        $version = getVersion($be->theme_version);


        if ($version == 'cleaning') {
            $rules['text_font_size'] = 'nullable';
        }

        if ($version == 'gym' || $version == 'car' || $version == 'cleaning') {
            $rules['bold_text'] = 'nullable';
            $rules['bold_text_font_size'] = 'required|integer|digits_between:1,3';
        }

        if ($version == 'cleaning') {
            $rules['bold_text_color'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $slider = new Slider;
        $slider->language_id = $request->language_id;
        $slider->title = $request->title;
        $slider->title_font_size = $request->title_font_size;

        if ($version == 'gym' || $version == 'car' || $version == 'cleaning') {
            $slider->bold_text = $request->bold_text;
            $slider->bold_text_font_size = $request->bold_text_font_size;
        }
        if ($version == 'cleaning') {
            $slider->bold_text_color = $request->bold_text_color;
        }

        if ($version != 'cleaning') {
            $slider->text = $request->text;
            $slider->text_font_size = $request->text_font_size;
        }


        $slider->button_text = $request->button_text;
        $slider->button_text_font_size = $request->button_text_font_size;
        $slider->button_url = $request->button_url;
        $slider->image = $request->slider_image;
        $slider->serial_number = $request->serial_number;
        $slider->save();

        Session::flash('success', 'Slider added successfully!');
        return "success";
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'slider']);
        }

        $slider = Slider::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/sliders/', $filename);
            @unlink('assets/front/img/sliders/' . $slider->image);
            $slider->image = $filename;
            $slider->save();
        }

        return response()->json(['status' => "success", "image" => "Slider", 'slider' => $slider]);
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'nullable',
            'title_font_size' => 'required|integer|digits_between:1,3',
            'text' => 'nullable',
            'text_font_size' => 'required|integer|digits_between:1,3',
            'button_text' => 'nullable',
            'button_text_font_size' => 'required|integer|digits_between:1,3',
            'button_url' => 'nullable|max:255',
            'serial_number' => 'required|integer',
        ];

        $be = BasicExtended::first();
        $version = getVersion($be->theme_version);

        if ($version == 'cleaning') {
            $rules['text_font_size'] = 'nullable';
        }

        if ($version == 'gym' || $version == 'car' || $version == 'cleaning') {
            $rules['bold_text'] = 'nullable';
            $rules['bold_text_font_size'] = 'required|integer|digits_between:1,3';
        }

        if ($version == 'cleaning') {
            $rules['bold_text_color'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $slider = Slider::findOrFail($request->slider_id);
        $slider->title = $request->title;
        $slider->title_font_size = $request->title_font_size;

        if ($version == 'gym' || $version == 'car' || $version == 'cleaning') {
            $slider->bold_text = $request->bold_text;
            $slider->bold_text_font_size = $request->bold_text_font_size;
        }

        if ($version == 'cleaning') {
            $slider->bold_text_color = $request->bold_text_color;
        }

        if ($version != 'cleaning') {
            $slider->text = $request->text;
            $slider->text_font_size = $request->text_font_size;
        }

        $slider->button_text = $request->button_text;
        $slider->button_text_font_size = $request->button_text_font_size;
        $slider->button_url = $request->button_url;
        $slider->serial_number = $request->serial_number;
        $slider->save();

        Session::flash('success', 'Slider updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $slider = Slider::findOrFail($request->slider_id);
        @unlink('assets/front/img/sliders/' . $slider->image);
        $slider->delete();

        Session::flash('success', 'Slider deleted successfully!');
        return back();
    }
}
