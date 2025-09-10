<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ETagMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        if ($response->isSuccessful() && $request->isMethodCacheable()) {
            $etag = md5($response->getContent());

            if ($request->getETags() && in_array($etag, $request->getETags())) {
                $response->setNotModified();
            }

            $response->setEtag($etag);
        }

        return $response;
    }
}
