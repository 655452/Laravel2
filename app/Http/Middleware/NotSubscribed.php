<?php

namespace App\Http\Middleware;

use Closure;

class NotSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->subscribed('main')) {
            return redirect()->route('account.subscriptions.index');
        }

        return $next($request);
    }
}
