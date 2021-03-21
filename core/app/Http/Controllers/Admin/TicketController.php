<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;
use Validator;
use Auth;
use XSSCleaner;
use App\Conversation;
use Session;
use App\Admin;

class TicketController extends Controller
{
    public function all(Request $request) {
        $search = $request->search;
        if(Auth::guard('admin')->user()->id == 1){
        $tickets = Ticket::orderby('last_message','DESC')
        ->when($search, function ($query, $search) {
            return $query->where('ticket_number', $search);
        })
        ->when($search, function ($query, $search) {
            return $query->orwhere('subject', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        }else{
            $tickets = Ticket::where('admin_id',Auth::guard('admin')->user()->id)
            ->when($search, function ($query, $search) {
                return $query->where('ticket_number', $search);
            })
            ->when($search, function ($query, $search) {
                return $query->orwhere('subject', 'like', '%' . $search . '%');
            })
            ->orderby('last_message','DESC')->paginate(10);
        }
        return view('admin.tickets.index',compact('tickets'));
    }

    public function pending(Request $request) {
        $search = $request->search;
        if(Auth::guard('admin')->user()->id == 1){
            $tickets = Ticket::where('status','pending')
            ->when($search, function ($query, $search) {
                return $query->where('ticket_number', $search);
            })
            ->when($search, function ($query, $search) {
                return $query->orwhere('subject', 'like', '%' . $search . '%');
            })
            ->orderby('id','desc')->paginate(10);
        }else{
            $tickets = Ticket::where('status','pending')
            ->when($search, function ($query, $search) {
                return $query->where('ticket_number', $search);
            })
            ->when($search, function ($query, $search) {
                return $query->orwhere('subject', 'like', '%' . $search . '%');
            })
            ->where('admin_id',Auth::guard('admin')->user()->id)->orderby('id','desc')->paginate(10);
        }
       return view('admin.tickets.index',compact('tickets'));
    }

    public function open(Request $request) {
        $search = $request->search;
        if(Auth::guard('admin')->user()->id == 1){
            $tickets = Ticket::where('status','open')
            ->when($search, function ($query, $search) {
                return $query->where('ticket_number', $search);
            })
            ->when($search, function ($query, $search) {
                return $query->orwhere('subject', 'like', '%' . $search . '%');
            })
            ->orderby('last_message','DESC')->paginate(10);
            }else{
                $tickets = Ticket::where('admin_id',Auth::guard('admin')->user()->id)
                ->when($search, function ($query, $search) {
                    return $query->where('ticket_number', $search);
                })
                ->when($search, function ($query, $search) {
                    return $query->orwhere('subject', 'like', '%' . $search . '%');
                })
                ->where('status','open')->orderby('last_message','DESC')
                ->paginate(10);
            }
       return view('admin.tickets.index',compact('tickets'));
    }

    public function closed(Request $request) {
        $search = $request->search;
       if(Auth::guard('admin')->user()->id == 1){
        $tickets = Ticket::where('status','close')
        ->when($search, function ($query, $search) {
            return $query->where('ticket_number', $search);
        })
        ->when($search, function ($query, $search) {
            return $query->orwhere('subject', 'like', '%' . $search . '%');
        })
        ->orderby('last_message','desc')->paginate(10);
       }else{
        $tickets = Ticket::where('status','close')
        ->when($search, function ($query, $search) {
            return $query->where('ticket_number', $search);
        })
        ->when($search, function ($query, $search) {
            return $query->orwhere('subject', 'like', '%' . $search . '%');
        })
        ->where('admin_id',Auth::guard('admin')->user()->id)->orderby('last_message','desc')->paginate(10);
       }

       return view('admin.tickets.index',compact('tickets'));
    }

    public function messages($id) {

        $ticket = Ticket::findOrFail($id);
        return view('admin.tickets.messages',compact('ticket'));
    }

    public function zip_file_upload(Request $request)
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


    public function ticketReply( Request $request , $id)
    {
        $file = $request->file('file');

        $rules = [
        'reply' => 'required',
        ];

        $ticket = Ticket::findOrFail($id);
        $request->validate($rules);
        $input = $request->all();

        $input['reply'] = XSSCleaner::clean($request->reply);
        $input['user_id'] = null;
        $input['admin_id'] = Auth::guard('admin')->user()->id;
        $input['ticket_id'] = $ticket->id;
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
            'status' => 'open',
        ]);

        Session::flash('success', 'message send successfully');
        return back();
    }

    public function ticketclose($id)
    {

        Ticket::where('id',$id)->update([
            'status' => 'close',
        ]);
        Session::flash('success', 'ticket close successfully.');
        return 'success';
    }




    public function ticketAssign(Request $request)
    {
        $rules = [
            'staff' => 'required',
            ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $admin = Admin::findOrFail($request->staff)->username;
       Ticket::where('id',$request->ticket_id)->update([
        'admin_id' => $request->staff
       ]);
       Session::flash('success', 'ticket assign to '.$admin);
       return 'success';

    }
}
