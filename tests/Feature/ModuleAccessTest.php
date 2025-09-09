<?php

namespace Tests\Feature;

use App\Models\User;
use App\Http\Middleware\SetUserLocale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ModuleAccessTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('activeModuleProvider')]
    public function test_active_module_index_route_accessible(string $path, string $view): void
    {
        $this->withoutMiddleware([SetUserLocale::class]);
        $user = User::factory()->create(['tenant_id' => 1]);
        $response = $this->actingAs($user)->get($path);
        $response->assertOk();
        $response->assertViewIs($view);
    }

    public function test_disabled_modules_do_not_register_routes(): void
    {
        $this->assertFalse(Route::has('inventory.index'));
    }

    public static function activeModuleProvider(): array
    {
        return [
            ['/cores', 'core::index'],
        ];
    }
}
