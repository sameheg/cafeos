<?php

namespace Modules\Qr\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Qr\Models\QrCode;

class QrDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        QrCode::firstOrCreate(
            ['tenant_id' => '00000000-0000-0000-0000-000000000000', 'table_id' => 'table1'],
            ['url' => 'https://example.com/qr/table1', 'generated_at' => now()]
        );
    }
}
