<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (file_exists(storage_path('installed'))) {
            if (Session()->has('applocale') AND Session()->get('applocale') AND setting('locale')) {
                App::setLocale(Session()->get('applocale'));
            } else {
                App::setLocale(setting('locale'));
            }
        }
        return $next($request);
    }
}
