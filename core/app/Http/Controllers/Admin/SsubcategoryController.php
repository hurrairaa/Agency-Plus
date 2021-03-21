<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ssubcategory;
use App\Scategory;
use Validator;
use Session;

class SsubcategoryController extends Controller
{
    public function index() {
      $data['ssubcategorys'] = Ssubcategory::all();
      $data['scats'] = Scategory::all();
      return view('admin.service.ssubcategory', $data);
    }

    public function edit($id) {
      $data['ssubcategory'] = Ssubcategory::findOrFail($id);
      return view('admin.home.ssubcategory.edit', $data);
    }

    public function store(Request $request) {
      $rules = [
        'name' => 'required|max:255',
        'category' => 'required',
        'status' => 'required'
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        $errmsgs = $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $ssubcategory = new Ssubcategory;
      $ssubcategory->scategory_id = $request->category;
      $ssubcategory->name = $request->name;
      $ssubcategory->status = $request->status;
      $ssubcategory->save();

      Session::flash('success', 'Subcategory added successfully!');
      return "success";
    }

    public function update(Request $request) {
      $rules = [
        'name' => 'required|max:255',
        'category' => 'required',
        'status' => 'required'
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        $errmsgs = $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $ssubcategory = Ssubcategory::findOrFail($request->ssubcategory_id);
      $ssubcategory->name = $request->name;
      $ssubcategory->scategory_id = $request->category;
      $ssubcategory->status = $request->status;
      $ssubcategory->save();

      Session::flash('success', 'Subcategory updated successfully!');
      return "success";
    }

    public function delete(Request $request) {

      $ssubcategory = Ssubcategory::findOrFail($request->ssubcategory_id);
      $ssubcategory->delete();

      Session::flash('success', 'Ssubcategory deleted successfully!');
      return back();
    }
}
