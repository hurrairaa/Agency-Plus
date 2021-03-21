<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bcategory;
use App\Language;
use Validator;
use Session;

class BcategoryController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['bcategorys'] = Bcategory::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;

        return view('admin.blog.bcategory.index', $data);
    }

    public function edit($id)
    {
        $data['bcategory'] = Bcategory::findOrFail($id);
        return view('admin.blog.bcategory.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'name' => 'required|max:255',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bcategory = new Bcategory;
        $bcategory->language_id = $request->language_id;
        $bcategory->name = $request->name;
        $bcategory->slug = slug_create($request->name);
        $bcategory->status = $request->status;
        $bcategory->serial_number = $request->serial_number;
        $bcategory->save();

        Session::flash('success', 'Blog category added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bcategory = Bcategory::findOrFail($request->bcategory_id);
        $bcategory->name = $request->name;
        $bcategory->slug = slug_create($request->name);
        $bcategory->status = $request->status;
        $bcategory->serial_number = $request->serial_number;
        $bcategory->save();

        Session::flash('success', 'Blog category updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $bcategory = Bcategory::findOrFail($request->bcategory_id);
        if ($bcategory->blogs()->count() > 0) {
            Session::flash('warning', 'First, delete all the blogs under this category!');
            return back();
        }
        $bcategory->delete();

        Session::flash('success', 'Blog category deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $bcategory = Bcategory::findOrFail($id);
            if ($bcategory->blogs()->count() > 0) {
                Session::flash('warning', 'First, delete all the blogs under the selected categories!');
                return "success";
            }
        }

        foreach ($ids as $id) {
            $bcategory = Bcategory::findOrFail($id);
            $bcategory->delete();
        }

        Session::flash('success', 'Blog categories deleted successfully!');
        return "success";
    }
}
