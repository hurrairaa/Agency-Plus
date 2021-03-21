<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Auth;
use Session;
use Hash;
use Validator;
use App\Admin;

class ProfileController extends Controller
{
    public function changePass() {
      return view('admin.profile.changepass');
    }

    public function editProfile() {
      $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
      return view('admin.profile.editprofile', ['admin' => $admin]);
    }

    public function updatePropic(Request $request) {
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
        return response()->json(['errors' => $validator->errors(), 'id' => 'image']);
      }

      @unlink("assets/admin/img/propics/".Auth::guard('admin')->user()->image);
      $fileName = uniqid() . '.jpg';
      $request->file('file')->move('assets/admin/img/propics/', $fileName);
      $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
      $admin->image = $fileName;
      $admin->save();
      return response()->json(['status' => "success", 'image' => 'image']);
    }

    public function updateProfile(Request $request) {
      $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

      $validatedData = $request->validate([
        'username' => [
            'required',
            'max:255',
            Rule::unique('admins')->ignore($admin->id)
        ],
        'email' => 'required|email|max:255',
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
      ]);


      $admin->username = $request->username;
      $admin->email = $request->email;
      $admin->first_name = $request->first_name;
      $admin->last_name = $request->last_name;
      $admin->save();

      Session::flash('success', 'Profile updated successfully!');

      return redirect()->back();
    }

    public function updatePassword(Request $request) {
      $messages = [
          'password.required' => 'The new password field is required',
          'password.confirmed' => "Password does'nt match"
      ];
      $validator = Validator::make($request->all(), [
          'old_password' => 'required',
          'password' => 'required|confirmed'
      ], $messages);
      // if given old password matches with the password of this authenticated user...
      if(Hash::check($request->old_password, Auth::guard('admin')->user()->password)) {
          $oldPassMatch = 'matched';
      } else {
          $oldPassMatch = 'not_matched';
      }
      if ($validator->fails() || $oldPassMatch=='not_matched') {
          if($oldPassMatch == 'not_matched') {
            $validator->errors()->add('oldPassMatch', true);
          }
          return redirect()->route('admin.changePass')
                      ->withErrors($validator);
      }

      // updating password in database...
      $user = Admin::findOrFail(Auth::guard('admin')->user()->id);
      $user->password = bcrypt($request->password);
      $user->save();

      Session::flash('success', 'Password changed successfully!');

      return redirect()->back();
    }
}
