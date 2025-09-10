<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class MfaFlowTest extends TestCase
{
    public function test_mfa_verification_succeeds_with_valid_code(): void
    {
        config(['security.mfa.enabled' => true]);

        $user = User::factory()->create();
        Cache::put('mfa_code_' . $user->id, '123456', now()->addMinutes(5));

        $response = $this->actingAs($user)->postJson('/mfa/verify', ['code' => '123456']);

        $response->assertOk()->assertJson(['message' => 'MFA verified']);
    }

    public function test_mfa_verification_fails_with_invalid_code(): void
    {
        config(['security.mfa.enabled' => true]);

        $user = User::factory()->create();
        Cache::put('mfa_code_' . $user->id, '123456', now()->addMinutes(5));

        $response = $this->actingAs($user)->postJson('/mfa/verify', ['code' => '000000']);

        $response->assertStatus(422);
    }
}

