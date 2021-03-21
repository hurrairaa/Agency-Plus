<?php

namespace App\Http\Controllers\User;

use App\BasicExtra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\ProductOrder;
use Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $bex = BasicExtra::first();
        if ($bex->is_shop == 0) {
            return back();
        }

        $orders = ProductOrder::where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();

        return view('user.order',compact('orders'));

    }

    public function orderdetails($id)
    {
        $bex = BasicExtra::first();
        if ($bex->is_shop == 0) {
            return back();
        }

        $data = ProductOrder::findOrFail($id);

        return view('user.order_details',compact('data'));

    }
}
