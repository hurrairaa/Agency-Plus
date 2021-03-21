<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;
use App\Role;
use Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        // dd($permission); // Basic Settings
        // if the admin is logged in & he has a role defined then this check will be applied
        if (Auth::guard('admin')->check() && !empty(Auth::guard('admin')->user()->role)) {
            $admin = Auth::guard('admin')->user();
            $permissions = json_decode($admin->role->permissions, true);
            if (!in_array($permission, $permissions)) {
              return back();
            }
        }
        return $next($request);
    }
}
