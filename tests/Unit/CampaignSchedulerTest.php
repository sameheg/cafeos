<?php

namespace Tests\Unit;

use App\Services\OpenAIService;
use Illuminate\Support\Facades\Bus;
use Modules\CRM\Jobs\SendCampaignMessage;
use Modules\CRM\Services\CampaignScheduler;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Resources\Chat;
use OpenAI\Responses\Chat\CreateResponse;
use Tests\TestCase;

class CampaignSchedulerTest extends TestCase
{
    private string $dbPath;

    protected function setUp(): void
    {
        $this->dbPath = sys_get_temp_dir() . '/' . uniqid('db', true) . '.sqlite';
        $pdo = new \PDO('sqlite:' . $this->dbPath);
        $pdo->exec('CREATE TABLE translation_overrides (id INTEGER PRIMARY KEY, locale TEXT, key TEXT, value TEXT)');

        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=' . $this->dbPath);
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        @unlink($this->dbPath);
    }

    public function test_schedule_generates_content_and_dispatches_messages(): void
    {
        OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'index' => 0,
                        'message' => ['role' => 'assistant', 'content' => 'Sale now!'],
                        'finish_reason' => 'stop',
                    ],
                ],
            ]),
        ]);

        Bus::fake();

        $scheduler = new CampaignScheduler(new OpenAIService());
        $scheduler->schedule('sms', 'Generate sale text', ['1234567890']);

        OpenAI::assertSent(Chat::class);

        Bus::assertDispatched(SendCampaignMessage::class, function ($job) {
            $ref = new \ReflectionClass($job);
            $prop = $ref->getProperty('content');
            $prop->setAccessible(true);

            return $prop->getValue($job) === 'Sale now!';
        });
    }
}
