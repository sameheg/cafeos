<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->getPreferredLanguage(['en', 'ar']) ?? config('app.locale');
        App::setLocale($locale);

        return $next($request);
    }
}
