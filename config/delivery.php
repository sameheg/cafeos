<?php

use App\DeliveryProviderCredential;
use Illuminate\Support\Facades\Schema;

$talabat = null;
$ubereats = null;

try {
    if (Schema::hasTable('delivery_provider_credentials')) {
        $talabat = DeliveryProviderCredential::for('talabat');
        $ubereats = DeliveryProviderCredential::for('ubereats');
    }
} catch (\Exception $e) {
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
