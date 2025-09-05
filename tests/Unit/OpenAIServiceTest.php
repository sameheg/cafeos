<?php

namespace Tests\Unit;

use App\Services\OpenAIService;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Resources\Chat;
use OpenAI\Responses\Chat\CreateResponse;
use Tests\TestCase;

class OpenAIServiceTest extends TestCase
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

    public function test_generate_campaign_content_calls_openai(): void
    {
        OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'index' => 0,
                        'message' => ['role' => 'assistant', 'content' => 'Promo text'],
                        'finish_reason' => 'stop',
                    ],
                ],
            ]),
        ]);

        $service = new OpenAIService();
        $result = $service->generateCampaignContent('Give me promo');

        $this->assertSame('Promo text', $result);
        OpenAI::assertSent(Chat::class, function ($method, $parameters) {
            return $parameters['messages'][0]['content'] === 'Give me promo';
        });
    }
}
