<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use App\Language;
use App\BasicSetting as BS;
use Session;
use Validator;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['apages'] = Page::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;
        return view('admin.page.index', $data);
    }

    public function create()
    {
        $data['tpages'] = Page::where('language_id', 0)->get();
        return view('admin.page.create', $data);
    }

    public function store(Request $request)
    {
        $slug = make_slug($request->name);

        $messages = [
            'language_id.required' => 'The language field is required',
        ];

        $rules = [
            'language_id' => 'required',
            'name' => 'required|max:25',
            'title' => 'required|max:30',
            'subtitle' => 'required|max:38',
            'body' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $page = new Page;
        $page->language_id = $request->language_id;
        $page->name = $request->name;
        $page->title = $request->title;
        $page->subtitle = $request->subtitle;
        $page->slug = $slug;
        $page->body = $request->body;
        $page->status = $request->status;
        $page->serial_number = $request->serial_number;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_description = $request->meta_description;
        $page->save();

        Session::flash('success', 'Page created successfully!');
        return "success";
    }

    public function edit($pageID)
    {
        $data['page'] = Page::findOrFail($pageID);
        return view('admin.page.edit', $data);
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->name);

        $rules = [
            'name' => 'required|max:25',
            'title' => 'required|max:30',
            'subtitle' => 'required|max:38',
            'body' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $pageID = $request->pageid;

        $page = Page::findOrFail($pageID);
        $page->name = $request->name;
        $page->title = $request->title;
        $page->subtitle = $request->subtitle;
        $page->slug = $slug;
        $page->body = $request->body;
        $page->status = $request->status;
        $page->serial_number = $request->serial_number;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_description = $request->meta_description;
        $page->save();

        Session::flash('success', 'Page updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $pageID = $request->pageid;
        $page = Page::findOrFail($pageID);
        $page->delete();
        Session::flash('success', 'Page deleted successfully!');
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $page = Page::findOrFail($id);
            $page->delete();
        }

        Session::flash('success', 'Pages deleted successfully!');
        return "success";
    }
}
