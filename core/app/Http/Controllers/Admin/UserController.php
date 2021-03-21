<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Admin;
use App\Role;
use Validator;
use Session;

class UserController extends Controller
{
    public function index() {
      $data['users'] = Admin::all();
      $data['roles'] = Role::all();
      return view('admin.user.index', $data);
    }

    public function edit($id) {
      $data['user'] = Admin::findOrFail($id);
      $data['roles'] = Role::all();
      return view('admin.user.edit', $data);
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
        return response()->json(['errors' => $validator->errors(), 'id' => 'user']);
      }

      $filename = time() . '.' . $img->getClientOriginalExtension();
      $request->session()->put('user_image', $filename);
      $request->file('file')->move('assets/admin/img/propics/', $filename);
      return response()->json(['status' => "session_put", "image" => "user", 'filename' => $filename]);
    }

    public function store(Request $request) {
      $messages = [
        'user.required' => 'Profile picture is required',
      ];

      $rules = [
        'user' => 'required',
        'username' => 'required|max:255|unique:admins',
        'email' => 'required|email|max:255|unique:admins',
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'password' => 'required|confirmed',
        'role' => 'required',
      ];

      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
        $errmsgs = $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $user = new Admin;
      $user->role_id = $request->role;
      $user->username = $request->username;
      $user->email = $request->email;
      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->password = bcrypt($request->password);
      $user->image = $request->user;
      $user->save();

      Session::flash('success', 'User created successfully!');
      return "success";
    }


    public function uploadUpdate(Request $request, $id) {
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
        return response()->json(['errors' => $validator->errors(), 'id' => 'user']);
      }

      $user = Admin::findOrFail($id);
      if ($request->hasFile('file')) {
        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->file('file')->move('assets/admin/img/propics/', $filename);
        @unlink('assets/admin/img/propics/'. $user->image);
        $user->image = $filename;
        $user->save();
      }

      return response()->json(['status' => "success", "image" => "User image", 'user' => $user]);
    }


    public function update(Request $request) {

      $user = Admin::findOrFail($request->user_id);

      $rules = [
        'username' => [
          'required',
          'max:255',
          Rule::unique('admins')->ignore($user->id),
        ],
        'email' => [
          'required',
          'email',
          'max:255',
          Rule::unique('admins')->ignore($user->id),
        ],
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'role' => 'required',
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        $errmsgs = $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $user->username = $request->username;
      $user->email = $request->email;
      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->status = $request->status;
      $user->role_id = $request->role;
      $user->save();

      Session::flash('success', 'User updated successfully!');
      return "success";
    }

    public function delete(Request $request) {
      if ($request->user_id == 1) {
        Session::flash('warning', 'You cannot delete the owner!');
        return back();
      }

      $user = Admin::findOrFail($request->user_id);
      $user->delete();

      Session::flash('success', 'User deleted successfully!');
      return back();
    }

    public function managePermissions($id) {
      $data['user'] = Admin::find($id);
      return view('admin.user.permission.manage', $data);
    }

    public function updatePermissions(Request $request) {
      $permissions = json_encode($request->permissions);
      $user = Admin::find($request->user_id);
      $user->permissions = $permissions;
      $user->save();

      Session::flash('success', "Permissions updated successfully for '$user->name' user");
      return back();
    }
}
