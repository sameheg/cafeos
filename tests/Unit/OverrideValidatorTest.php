<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use Laravel\Pennant\Feature;
use Modules\Franchise\Models\FranchiseTemplate;
use Tests\TestCase;

class OverrideValidatorTest extends TestCase
{
    public function test_margin_guard_blocks_negative_price(): void
    {
        Feature::define('franchise_margin_guards', fn () => true);

        $template = FranchiseTemplate::create([
            'tenant_id' => (string) Str::uuid(),
            'type' => 'recipe',
            'data' => ['price' => 10],
        ]);

        $response = $this->patchJson('/v1/franchise/templates/' . $template->id, [
            'changes' => ['price' => -5],
        ]);

        $response->assertStatus(409);
    }
}
