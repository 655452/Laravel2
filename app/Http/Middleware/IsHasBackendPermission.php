<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsHasBackendPermission
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
        $permissionRole = [2];

        if (Auth::user() && !in_array(Auth::user()->myrole, $permissionRole)) {
            return $next($request);
        }

        return redirect('/');
    }
}
