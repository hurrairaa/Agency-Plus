<?php

namespace App\Http\Controllers\Front;
use App\ProductReview;
use App\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class ReviewController extends Controller
{
    public function reviewsubmit(Request $request)
    {

        if($request->review || $request->comment){
            if(ProductReview::where('user_id',Auth::user()->id)->where('product_id',$request->product_id)->exists()){
                $exists =    ProductReview::where('user_id',Auth::user()->id)->where('product_id',$request->product_id)->first();
                if($request->review){
                    $exists->update([
                        'review' => $request->review,
                    ]);
                    $avgreview = ProductReview::where('product_id',$request->product_id)->avg('review');
                    Product::find($request->product_id)->update([
                        'rating' => $avgreview
                    ]);
                }if($request->comment){
                    $exists->update([
                        'comment' => $request->comment,
                    ]);
                }
                Session::flash('success', 'Review update successfully');
                return back();
            }else{
                $input = $request->all();
                $input['user_id'] = Auth::user()->id;
                $data = new ProductReview;
                $data->create($input);
                $avgreview = ProductReview::where('product_id',$request->product_id)->avg('review');
                Product::find($request->product_id)->update([
                    'rating' => $avgreview
                ]);
                Session::flash('success', 'Review submit successfully');
                return back();
            } 
        }else{
            Session::flash('error', 'Review submit not succesfull');
            return back();
        }
   
    }

    public function authcheck()
    {
        if(!Auth::user()){
            Session::put('link',url()->current());
            return redirect(route('user.login'));
        }
    }
}
