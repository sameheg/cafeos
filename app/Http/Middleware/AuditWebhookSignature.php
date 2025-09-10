<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class AuditWebhookSignature
{
    public function handle(Request $request, Closure $next)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            Webhook::constructEvent($payload, $signature ?? '', $secret);
            Log::channel('audit')->info('webhook.signature.verified', [
                'event' => 'stripe',
            ]);
        } catch (\UnexpectedValueException|SignatureVerificationException $e) {
            Log::channel('audit')->warning('webhook.signature.invalid', [
                'event' => 'stripe',
                'message' => $e->getMessage(),
            ]);

            return response('Invalid signature', 400);
        }

        return $next($request);
    }
}
