<?php

namespace Tests\Feature;

use App\Models\User;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    public function test_user_can_login(): void
    {
        $tenant = Tenant::create(['name' => 'Acme', 'subdomain' => 'acme']);
        User::create([
            'name' => 'Test',
            'email' => 'user@acme.test',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
        ]);

        $this->assertTrue(auth()->attempt(['email' => 'user@acme.test', 'password' => 'password']));
    }
}
