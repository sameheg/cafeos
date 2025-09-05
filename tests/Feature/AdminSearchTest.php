<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminSearchTest extends TestCase
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
    }

    public function test_search_returns_matching_users()
    {
        $admin = User::create([
            'surname' => 'Mr',
            'first_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
            'language' => 'en',
        ]);

        $jane = User::create([
            'surname' => 'Ms',
            'first_name' => 'Jane',
            'username' => 'jane',
            'email' => 'jane@example.com',
            'password' => bcrypt('secret'),
            'language' => 'en',
        ]);

        $response = $this->actingAs($admin)->getJson(route('admin.search', ['query' => 'Jane']));

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Ms Jane']);
    }
}

