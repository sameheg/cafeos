<?php

use App\DeliveryProviderCredential;
use Illuminate\Support\Facades\Schema;
use Exception;

$talabat = null;
$ubereats = null;

try {
    if (Schema::hasTable('delivery_provider_credentials')) {
        $talabat = DeliveryProviderCredential::where('provider', 'talabat')->first();
        $ubereats = DeliveryProviderCredential::where('provider', 'ubereats')->first();
    }
} catch (Exception $e) {
    // Ignore if table does not exist
}

return [
    'providers' => [
        'talabat' => [
            'client_id' => $talabat->token ?? env('TALABAT_CLIENT_ID'),
            'client_secret' => $talabat->secret ?? env('TALABAT_CLIENT_SECRET'),
            'base_uri' => env('TALABAT_BASE_URI', 'https://api.talabat.com'),
        ],
        'ubereats' => [
            'client_id' => $ubereats->token ?? env('UBEREATS_CLIENT_ID'),
            'client_secret' => $ubereats->secret ?? env('UBEREATS_CLIENT_SECRET'),
            'base_uri' => env('UBEREATS_BASE_URI', 'https://api.ubereats.com'),
        ],
    ],
];
