<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CalendarEvent;
use App\Language;
use Validator;
use Session;

class CalendarController extends Controller
{
    public function index(Request $request) {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['events'] = CalendarEvent::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;

        return view('admin.calendar.index', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $calendar = new CalendarEvent;
        $calendar->language_id = $request->language_id;
        $calendar->title = $request->title;
        $calendar->start_date = $request->start_date;
        $calendar->end_date = $request->end_date;

        $calendar->save();

        Session::flash('success', 'Event added to calendar successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $messages = [
            'start_date.required' => 'Event period is required',
            'end_date.required' => 'Event period is required',
        ];

        $rules = [
            'title' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $calendar = CalendarEvent::findOrFail($request->event_id);
        $calendar->title = $request->title;
        $calendar->start_date = $request->start_date;
        $calendar->end_date = $request->end_date;
        $calendar->save();

        Session::flash('success', 'Event date updated in calendar successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $calendar = CalendarEvent::findOrFail($request->event_id);
        $calendar->delete();

        Session::flash('success', 'Event deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $calendar = CalendarEvent::findOrFail($id);
            $calendar->delete();
        }

        Session::flash('success', 'Events deleted successfully!');
        return "success";
    }
}
