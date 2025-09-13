<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WebhookService
{
    public function send(string $hook, array $payload): void
    {
        $url = config("services.webhooks.$hook");

        if ($url) {
            Http::post($url, $payload);
        }
    }
}
