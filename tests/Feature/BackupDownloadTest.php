<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BackupDownloadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        config(['constants.administrator_usernames' => 'admin']);
        config(['backup.backup.destination.disks' => ['local', 's3']]);
    }

    protected function getAdminUser(): User
    {
        $user = new User([
            'username' => 'admin',
            'surname' => 'Admin',
            'first_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
        ]);
        $user->id = 1;

        return $user;
    }

    public function test_can_download_backup_from_local_disk()
    {
        Storage::fake('local');
        Storage::fake('s3');

        $fileName = 'test.zip';
        $path = config('backup.backup.name').'/'.$fileName;
        Storage::disk('local')->put($path, 'local-content');

        $this->actingAs($this->getAdminUser());

        $response = $this->get('/backup/download/'.$fileName);

        $response->assertOk();
        $this->assertEquals('local-content', $response->streamedContent());
    }

    public function test_can_download_backup_from_s3_disk()
    {
        Storage::fake('local');
        Storage::fake('s3');

        $fileName = 'test.zip';
        $path = config('backup.backup.name').'/'.$fileName;
        Storage::disk('s3')->put($path, 's3-content');

        $this->actingAs($this->getAdminUser());

        $response = $this->get('/backup/download/'.$fileName);

        $response->assertOk();
        $this->assertEquals('s3-content', $response->streamedContent());
    }
}
