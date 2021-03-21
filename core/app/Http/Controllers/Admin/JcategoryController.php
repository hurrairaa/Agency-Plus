<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jcategory;
use App\Language;
use Validator;
use Session;

class JcategoryController extends Controller
{
    public function index(Request $request) {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['jcategorys'] = Jcategory::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        return view('admin.job.jcategory.index', $data);
    }

    public function edit($id) {
        $data['jcategory'] = Jcategory::findOrFail($id);
        return view('admin.job.jcategory.edit', $data);
    }

    public function store(Request $request) {
        $messages = [
            'language_id.required' => 'The language field is required',
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

        $jcategory = new Jcategory;
        $jcategory->language_id = $request->language_id;
        $jcategory->name = $request->name;
        $jcategory->status = $request->status;
        $jcategory->serial_number = $request->serial_number;
        $jcategory->save();

        Session::flash('success', 'Category added successfully!');
        return "success";
    }

    public function update(Request $request) {
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

        $jcategory = Jcategory::findOrFail($request->jcategory_id);
        $jcategory->name = $request->name;
        $jcategory->status = $request->status;
        $jcategory->serial_number = $request->serial_number;
        $jcategory->save();

        Session::flash('success', 'Category updated successfully!');
        return "success";
    }

    public function delete(Request $request) {
        $jcategory = Jcategory::findOrFail($request->jcategory_id);
        if ($jcategory->jobs()->count() > 0) {
            Session::flash('warning', 'First, delete all the jobs under this category!');
            return back();
        }
        $jcategory->delete();

        Session::flash('success', 'Category deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $jcategory = Jcategory::findOrFail($id);
            if ($jcategory->jobs()->count() > 0) {
                Session::flash('warning', 'First, delete all the jobs under the selected categories!');
                return "success";
            }
        }

        foreach ($ids as $id) {
            $jcategory = Jcategory::findOrFail($id);
            $jcategory->delete();
        }

        Session::flash('success', 'Job categories deleted successfully!');
        return "success";
    }
}
