<?php

namespace Modules\Billing\Services;

use RuntimeException;

class PaymentGatewayManager
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Create a subscription for the given tenant using the configured provider
     * and optional corporate account.
     */
    public function createSubscription(string $provider, array $payload, string $account = 'default'): array
    {
        if (! isset($this->config[$provider])) {
            throw new RuntimeException("Unsupported provider [$provider]");
        }

        $accounts = $this->config[$provider]['accounts'] ?? [];

        if (! isset($accounts[$account])) {
            throw new RuntimeException("Unsupported account [$account] for provider [$provider]");
        }

        // Integration points for real providers can be added here.
        // For now this simply returns the payload for demonstration purposes.
        return [
            'provider' => $provider,
            'account' => $account,
            'payload' => $payload,
        ];
    }
}
