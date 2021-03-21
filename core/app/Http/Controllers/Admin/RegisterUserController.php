<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Session;

class RegisterUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.register_user.index',compact('users'));
    }

    public function view($id)
    {
        $user = User::findOrFail($id);
        $orders = $user->orders()->paginate(10);
        return view('admin.register_user.details',compact('user', 'orders'));

    }


    public function userban(Request $request)
    {

        $user = User::findOrFail($request->user_id);
        $user->update([
            'status' => $request->status,
        ]);

    Session::flash('success', $user->username.' status update successfully!');
    return back();



    }
}
