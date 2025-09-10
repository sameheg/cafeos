<?php

namespace Tests\Ui;

use App\Http\Middleware\SetUserLocale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ModuleContentTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('activeModuleProvider')]
    public function test_index_page_shows_module_name(string $path, string $name): void
    {
        $this->withoutMiddleware([SetUserLocale::class]);
        $user = User::factory()->create([
            'tenant_id' => 1,
            'email_verified_at' => now(),
        ]);
        $response = $this->actingAs($user)->get($path);
        $response->assertSee("Module: {$name}");
    }

    public static function activeModuleProvider(): array
    {
        return [
            ['/cores', 'Core'],
        ];
    }
}
