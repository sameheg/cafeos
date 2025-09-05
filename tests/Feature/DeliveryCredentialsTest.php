<?php

namespace Tests\Feature;

use App\DeliveryProviderCredential;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryCredentialsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_prefers_database_credentials_over_env()
    {
        config()->set('delivery.providers.talabat.client_id', 'env-id');
        config()->set('delivery.providers.talabat.client_secret', 'env-secret');

        DeliveryProviderCredential::create([
            'provider' => 'talabat',
            'business_id' => null,
            'token' => 'db-id',
            'secret' => 'db-secret',
        ]);

        $config = require base_path('config/delivery.php');
        config(['delivery.providers.talabat' => $config['providers']['talabat']]);

        $this->assertEquals('db-id', config('delivery.providers.talabat.client_id'));
        $this->assertEquals('db-secret', config('delivery.providers.talabat.client_secret'));
    }
}
