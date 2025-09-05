<?php

namespace Tests\Unit;

use App\Utils\NotificationUtil;
use Mockery;
use Tests\TestCase;
use Twilio\Rest\Client as TwilioClient;

class NotificationUtilTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_send_whatsapp_uses_client()
    {
        config(['services.twilio_whatsapp' => [
            'sid' => 'sid',
            'token' => 'token',
            'from' => '123456',
        ]]);

        $data = [
            'mobile_number' => '9876543210',
            'whatsapp_text' => 'Hello',
        ];

        $messagesMock = Mockery::mock();
        $messagesMock->shouldReceive('create')
            ->once()
            ->with('whatsapp:9876543210', [
                'from' => 'whatsapp:123456',
                'body' => 'Hello',
            ]);

        $clientMock = Mockery::mock(TwilioClient::class);
        $clientMock->messages = $messagesMock;

        $util = new NotificationUtil();
        $util->sendWhatsapp($data, $clientMock);
    }
}
