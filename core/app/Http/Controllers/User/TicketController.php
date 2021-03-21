<?php

namespace App\Http\Controllers\User;

use App\BasicExtra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Conversation;
use App\Language;
use Session;
use XSSCleaner;
use Validator;
use Auth;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index()
    {
        $bex = BasicExtra::first();

        if ($bex->is_ticket == 0) {
            return back();
        }
        $data['tickets'] = Ticket::where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();

        return view('user.tickets.index', $data);

    }

    public function create()
    {
        $bex = BasicExtra::first();

        if ($bex->is_ticket == 0) {
            return back();
        }
        return view('user.tickets.create');
    }

    public function ticketstore(Request $request)
    {

        $file = $request->file('zip_file');
        $allowedExts = array('zip');
        $rules = [
            'subject' => 'required',
            'description' => 'required',
            'email' => 'required|email',

        'zip_file' => [
            function ($attribute, $value, $fail) use ($file, $allowedExts) {

                $ext = $file->getClientOriginalExtension();
                if (!in_array($ext, $allowedExts)) {
                    return $fail("Only zip file supported");
                }
            },
            'max:5000'
        ],
        ];

        $messages = [
            'zip_file.max' => ' zip file may not be greater than 5 MB',
        ];

        $request->validate($rules, $messages);
        $input = $request->all();

        if($request->hasFile('zip_file')){
            $file = $request->file('zip_file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('assets/front/user-suppor-file/', $filename);
            $input['zip_file'] = $filename;
        }

        $input['message'] = XSSCleaner::clean($request->description);
        $input['user_id'] = Auth::user()->id;
        $input['ticket_number'] = rand(1000000,9999999);

        $data = new Ticket;
        $data->create($input);

        $files = glob('assets/front/temp/*');
        foreach($files as $file){
            unlink($file);
        }

        Session::flash('success', 'Ticket Submitted Successfully');
        return redirect(route('user-tickets'));

    }

    public function messages($id)
    {
        $bex = BasicExtra::first();

        if ($bex->is_ticket == 0) {
            return back();
        }
        $data['ticket'] = Ticket::where('ticket_number',$id)->first();

        return view('user.tickets.messages',$data);

    }

    public function ticketreply(Request $request , $id)
    {
        $file = $request->file('file');
        $allowedExts = array('zip');
        $rules = [
        'reply' => 'required',
        'file' => [
            function ($attribute, $value, $fail) use ($file, $allowedExts) {

                $ext = $file->getClientOriginalExtension();
                if (!in_array($ext, $allowedExts)) {
                    return $fail("Only zip file supported");
                }
            },
            'max:5000'
        ],
        ];

        $messages = [
            'file.max' => ' zip file may not be greater than 5 MB',
        ];

        $request->validate($rules, $messages);
        $input = $request->all();

        $input['reply'] = XSSCleaner::clean($request->reply);
        $input['user_id'] = Auth::user()->id;
        $input['admin_id'] = null;
        $input['ticket_id'] = $id;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('assets/front/user-suppor-file/', $filename);
            $input['file'] = $filename;
        }

        $data = new Conversation;
        $data->create($input);

        $files = glob('assets/front/temp/*');
        foreach($files as $file){
            unlink($file);
        }

        Ticket::where('id',$id)->update([
            'last_message' => Carbon::now(),
        ]);

        Session::flash('success', 'Message Sent Successfully');
        return back();

    }


    public function zip_upload(Request $request)
    {

        $file = $request->file('file');
        $allowedExts = array('zip');
        $rules = [
        'file' => [
            function ($attribute, $value, $fail) use ($file, $allowedExts) {
                $ext = $file->getClientOriginalExtension();
                if (!in_array($ext, $allowedExts)) {
                    return $fail("Only zip file supported");
                }
            },
            'max:5000'
        ],
        ];

        $messages = [
            'file.max' => ' zip file may not be greater than 5 MB',
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
          }

        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('assets/front/temp/', $filename);
            $input['file'] = $filename;
        }

        return response()->json(['data'=>1]);

    }
}
