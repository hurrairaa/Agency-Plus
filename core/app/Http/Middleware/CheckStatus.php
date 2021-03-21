<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class CheckStatus
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
        if (Auth::guard('admin')->check() && !empty(Auth::guard('admin')->user()->role_id) && Auth::guard('admin')->user()->status == 0) {
          Auth::guard('admin')->logout();
          Session::flash('warning', 'Your account has been banned by Admin!');
          return redirect()->route('admin.login');
        }
        return $next($request);
    }
}
