<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;
use App\Language;
use Validator;
use Session;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['faqs'] = Faq::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;

        return view('admin.home.faq.index', $data);
    }

    public function edit($id)
    {
        $data['faq'] = Faq::findOrFail($id);
        return view('admin.home.faq.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'question' => 'required|max:255',
            'answer' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $faq = new Faq;
        $faq->language_id = $request->language_id;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->serial_number = $request->serial_number;
        $faq->save();

        Session::flash('success', 'Faq added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'question' => 'required|max:255',
            'answer' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $faq = Faq::findOrFail($request->faq_id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->serial_number = $request->serial_number;
        $faq->save();

        Session::flash('success', 'Faq updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $faq = Faq::findOrFail($request->faq_id);
        $faq->delete();

        Session::flash('success', 'Faq deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $faq = Faq::findOrFail($id);
            $faq->delete();
        }

        Session::flash('success', 'FAQs deleted successfully!');
        return "success";
    }
}
