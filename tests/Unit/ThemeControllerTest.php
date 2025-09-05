<?php

namespace Tests\Unit;

use App\Http\Controllers\ThemeController;
use App\User;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class ThemeControllerTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_theme_preference_is_persisted()
    {
        $controller = new ThemeController();
        $user = Mockery::mock(User::class)->makePartial();
        $user->settings = [];
        $user->shouldReceive('save')->once()->andReturnTrue();

        $request = Request::create('/theme', 'POST', ['theme' => 'dark']);
        $request->setUserResolver(fn () => $user);

        $response = $controller->update($request);
        $data = $response->getData(true);

        $this->assertEquals('dark', $user->settings['theme']);
        $this->assertEquals('success', $data['status']);
    }
}
