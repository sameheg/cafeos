<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class SetUserLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->user()->locale ?? config('app.locale');
        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
