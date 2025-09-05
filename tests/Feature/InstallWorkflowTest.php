<?php

namespace Tests\Feature;

use Tests\TestCase;

class InstallWorkflowTest extends TestCase
{
    public function tearDown(): void
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            unlink($envPath);
        }
        parent::tearDown();
    }

    public function test_it_creates_env_file_and_redirects_to_success()
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            unlink($envPath);
        }

        $data = [
            'APP_NAME' => 'TestApp',
            'ENVATO_PURCHASE_CODE' => 'testcode',
            'DB_DATABASE' => 'test_db',
            'DB_USERNAME' => 'user',
            'DB_PASSWORD' => 'pass',
            'DB_HOST' => '127.0.0.1',
            'DB_PORT' => '3306',
        ];

        $response = $this->post('/install/post-details', $data);

        $response->assertRedirect(route('install.success'));
        $this->assertFileExists($envPath);
        $contents = file_get_contents($envPath);
        $this->assertStringContainsString('APP_NAME="TestApp"', $contents);
    }
}
