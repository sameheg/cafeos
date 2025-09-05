<?php

namespace Tests\Feature;

use App\Tenant;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Superadmin\Entities\Plan;
use Modules\Superadmin\Entities\Subscription;
use Modules\Superadmin\Providers\SuperadminServiceProvider;
use Tests\TestCase;

class SuperadminModuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
        $this->app->register(SuperadminServiceProvider::class);
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });
        (require base_path('Modules/Superadmin/Database/Migrations/2024_06_01_100000_create_plans_table.php'))->up();
        (require base_path('Modules/Superadmin/Database/Migrations/2024_06_01_100001_create_subscriptions_table.php'))->up();
        (require base_path('Modules/Superadmin/Database/Migrations/2024_06_01_100002_create_invoices_table.php'))->up();
    }

    /** @test */
    public function it_creates_tenant_and_activates_plan()
    {
        config(['constants.administrator_usernames' => 'admin']);
        $user = User::create(['username' => 'admin', 'password' => bcrypt('secret')]);
        $tenant = Tenant::create(['name' => 'Alpha', 'slug' => 'alpha']);
        app()->instance('tenant', $tenant);
        $plan = Plan::create(['name' => 'Basic', 'price' => 10, 'interval' => 'monthly']);

        $this->actingAs($user)
            ->post(route('superadmin.subscribe'), ['plan_id' => $plan->id])
            ->assertRedirect(route('superadmin.pricing'));

        $this->assertDatabaseHas('subscriptions', ['tenant_id' => $tenant->id, 'plan_id' => $plan->id]);
        $this->assertDatabaseHas('invoices', ['tenant_id' => $tenant->id, 'amount' => 10]);
    }

    /** @test */
    public function superadmin_middleware_allows_configured_user()
    {
        config(['constants.administrator_usernames' => 'admin']);
        $user = User::create(['username' => 'admin', 'password' => bcrypt('secret')]);
        \Illuminate\Support\Facades\Route::middleware('superadmin')->get('/superadmin-test', function () {
            return 'ok';
        });
        $response = $this->actingAs($user)->get('/superadmin-test');
        $response->assertOk();
    }

    /** @test */
    public function plan_features_are_available_per_tenant()
    {
        $tenant = Tenant::create(['name' => 'Alpha', 'slug' => 'alpha']);
        app()->instance('tenant', $tenant);
        $plan = Plan::create(['name' => 'Pro', 'price' => 20, 'interval' => 'monthly', 'features' => ['reports' => true]]);
        Subscription::create(['tenant_id' => $tenant->id, 'plan_id' => $plan->id, 'starts_at' => now(), 'ends_at' => now()->addMonth(), 'status' => 'active']);

        $subscription = Subscription::where('tenant_id', $tenant->id)->with('plan')->first();
        $this->assertTrue($subscription->plan->features['reports']);
    }
}
