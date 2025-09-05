<?php

namespace Tests\Unit;

use App\Http\Controllers\Controller;
use Exception;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    public function test_respond_went_wrong_shows_exception_message_in_debug()
    {
        config(['app.debug' => true]);
        $controller = new Controller();
        $exception = new Exception('Test error');
        $response = $controller->respondWentWrong($exception);
        $data = $response->getData(true);

        $this->assertFalse($data['success']);
        $this->assertEquals('Test error', $data['msg']);
    }

    public function test_respond_went_wrong_hides_exception_message_in_production()
    {
        config(['app.debug' => false]);
        $controller = new Controller();
        $exception = new Exception('Test error');
        $response = $controller->respondWentWrong($exception);
        $data = $response->getData(true);

        $this->assertFalse($data['success']);
        $this->assertEquals(trans('messages.something_went_wrong'), $data['msg']);
    }
}
