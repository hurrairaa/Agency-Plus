<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Role;
use Validator;
use Session;

class RoleController extends Controller
{
    public function index() {
      $data['roles'] = Role::all();
      return view('admin.role.index', $data);
    }

    public function store(Request $request) {

      $rules = [
        'name' => 'required|max:255',
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        $errmsgs = $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $role = new Role;
      $role->name = $request->name;
      $role->save();

      Session::flash('success', 'Role added successfully!');
      return "success";
    }

    public function update(Request $request) {
      $rules = [
        'name' => 'required|max:255',
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        $errmsgs = $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $role = Role::findOrFail($request->role_id);
      $role->name = $request->name;
      $role->save();

      Session::flash('success', 'Role updated successfully!');
      return "success";
    }

    public function delete(Request $request) {

      $role = Role::findOrFail($request->role_id);
      if ($role->admins()->count() > 0) {
        Session::flash('warning', 'Please delete the users under this role first.');
        return back();
      }
      $role->delete();

      Session::flash('success', 'Role deleted successfully!');
      return back();
    }

    public function managePermissions($id) {
      $data['role'] = Role::find($id);
      return view('admin.role.permission.manage', $data);
    }

    public function updatePermissions(Request $request) {
      $permissions = json_encode($request->permissions);
      $role = Role::find($request->role_id);
      $role->permissions = $permissions;
      $role->save();

      Session::flash('success', "Permissions updated successfully for '$role->name' role");
      return back();
    }
}
