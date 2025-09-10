<?php

namespace Tests\Feature;

use App\Http\Middleware\SetSecurityHeaders;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_middleware_adds_security_headers(): void
    {
        $middleware = new SetSecurityHeaders();
        $request = Request::create('/', 'GET');
        $response = $middleware->handle($request, fn ($req) => new Response());

        $this->assertSame("default-src 'self'; img-src 'self' data:; script-src 'self'; style-src 'self' 'unsafe-inline'", $response->headers->get('Content-Security-Policy'));
        $this->assertSame('max-age=63072000; includeSubDomains; preload', $response->headers->get('Strict-Transport-Security'));
        $this->assertSame('same-origin', $response->headers->get('Cross-Origin-Opener-Policy'));
        $this->assertSame('same-origin', $response->headers->get('Cross-Origin-Resource-Policy'));
    }
}

