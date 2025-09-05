<?php

namespace App\Jobs;

use App\DeliveryOrder;
use App\DeliveryProviderCredential;
use App\Services\Delivery\DeliveryProvider;
use App\Services\Delivery\TalabatAdapter;
use App\Services\Delivery\UberEatsAdapter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncDeliveryOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $providerName;

    public function __construct(string $providerName)
    {
        $this->providerName = $providerName;
    }

    public function handle(): void
    {
        $credentials = DeliveryProviderCredential::where('provider', $this->providerName)->first();
        if ($credentials) {
            config([
                "delivery.providers.{$this->providerName}.client_id" => $credentials->token,
                "delivery.providers.{$this->providerName}.client_secret" => $credentials->secret,
            ]);
        }

        $provider = $this->resolveProvider($this->providerName);
        foreach ($provider->fetchOrders() as $order) {
            if (isset($order['id'], $order['status'])) {
                DeliveryOrder::firstOrCreate(
                    ['external_id' => $order['id'], 'provider' => $this->providerName],
                    ['status' => $order['status']]
                );
                $provider->updateOrderStatus($order['id'], $order['status']);
            }
        }
    }

    protected function resolveProvider(string $name): DeliveryProvider
    {
        return match ($name) {
            'talabat' => app(TalabatAdapter::class),
            'ubereats' => app(UberEatsAdapter::class),
            default => throw new \InvalidArgumentException("Unknown provider {$name}"),
        };
    }
}
