<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        Schema::create('business', function (Blueprint $table) {
            $table->increments('id');
        });
        DB::table('business')->insert(['id' => 1]);

        $usersMigration = include base_path('database/migrations/2014_10_12_000000_create_users_table.php');
        $usersMigration->up();

        $permissionMigration = include base_path('database/migrations/2017_07_26_083429_create_permission_tables.php');
        $permissionMigration->up();
    }

    public function test_can_create_permission()
    {
        $user = User::create([
            'surname' => 'Mr',
            'first_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
            'language' => 'en',
        ]);

        $response = $this->actingAs($user)->post(route('admin.permissions.store'), [
            'name' => 'edit articles',
        ]);

        $response->assertRedirect(route('admin.permissions.index'));
        $this->assertDatabaseHas('permissions', ['name' => 'edit articles']);
    }

    public function test_can_create_role_with_permissions()
    {
        $user = User::create([
            'surname' => 'Mr',
            'first_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
            'language' => 'en',
        ]);

        $permission = Permission::create(['name' => 'edit articles', 'guard_name' => 'web']);

        $response = $this->actingAs($user)->post(route('admin.roles.store'), [
            'name' => 'editor',
            'permissions' => [$permission->id],
        ]);

        $response->assertRedirect(route('admin.roles.index'));

        $role = Role::where('name', 'editor')->first();
        $this->assertNotNull($role);
        $this->assertTrue($role->hasPermissionTo('edit articles'));
    }
}
