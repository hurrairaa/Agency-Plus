<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use Validator;
use Session;

class AboutController extends Controller
{
    public function index() {
      return view('admin.about.informations');
    }

    public function upload(Request $request) {
      $img = $request->file('file');
      $allowedExts = array('jpg', 'png', 'jpeg');

      $rules = [
        'file' => [
          function($attribute, $value, $fail) use ($img, $allowedExts) {
            if (!empty($img)) {
              $ext = $img->getClientOriginalExtension();
              if(!in_array($ext, $allowedExts)) {
                  return $fail("Only png, jpg, jpeg image is allowed");
              }
            }
          },
        ],
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        $validator->getMessageBag()->add('error', 'true');
        return response()->json(['errors' => $validator->errors(), 'id' => 'video_background']);
      }

      @unlink("assets/front/images/video_background.jpg");
      $request->file('file')->move('assets/front/images/', 'video_background.jpg');
      return response()->json(['status' => "success", 'image' => 'Video background']);
    }

    public function update(Request $request) {
      $rules = [
        'title' => 'required|max:255',
        'information' => 'required',
        'url' => 'required|max:255',
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        $errmsgs = $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $bs = BS::first();
      $bs->about_title = $request->title;
      $bs->about_text = $request->information;
      $bs->about_video_url = $request->url;
      $bs->save();

      Session::flash('success', 'Informations updated successfully!');
      return "success";
    }
}
