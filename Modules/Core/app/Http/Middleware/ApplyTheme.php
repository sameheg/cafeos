<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Models\Theme;
use Symfony\Component\HttpFoundation\Response;

class ApplyTheme
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->bound('tenant')) {
            $theme = Theme::where('tenant_id', app('tenant')->id)->first();
            if ($theme) {
                view()->share('theme', $theme);
            }
        }

        return $next($request);
    }
}
