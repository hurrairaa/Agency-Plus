<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class UserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->status != 1){
            Auth::guard('web')->logout();
            Session::flash('success','Your account has been banned!');
            return redirect(route('front.index'));
        }
        return $next($request);
    }
}
