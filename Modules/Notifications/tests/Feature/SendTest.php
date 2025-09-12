<?php

namespace Modules\Notifications\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Modules\Notifications\Models\NotificationTemplate;
use Tests\TestCase;

class SendTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_can_send_notification(): void
    {
        \Modules\Core\Models\Tenant::forceCreate(['id' => 't1', 'name' => 'Tenant', 'subdomain' => 't1']);
        app()->instance('tenant', \Modules\Core\Models\Tenant::find('t1'));
        $template = NotificationTemplate::create([
            'tenant_id' => 't1',
            'name' => 'welcome',
            'content' => 'Welcome',
        ]);

        $user = User::create([
            'id' => Str::ulid(),
            'tenant_id' => 't1',
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('secret'),
        ]);
        config(['auth.guards.sanctum' => ['driver' => 'session', 'provider' => 'users']]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/notifications', [
            'template' => 'welcome',
            'recipients' => ['user@example.com'],
        ]);

        $response->assertStatus(200)->assertJsonStructure(['notif_id']);
    }
}
