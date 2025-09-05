<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\User;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery;
use Tests\TestCase;

class TwoFactorTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_enabling_two_factor_sets_secret_and_recovery_codes()
    {
        $controller = new TwoFactorController();

        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('save')->once()->andReturnTrue();

        $request = Request::create('/two-factor', 'GET');
        $request->setUserResolver(fn () => $user);

        $controller->index($request);

        $this->assertNotEmpty($user->two_factor_secret);
        $this->assertNotEmpty($user->two_factor_recovery_codes);
    }

    public function test_login_redirects_to_two_factor_challenge_when_secret_exists()
    {
        $businessUtil = Mockery::mock(BusinessUtil::class);
        $businessUtil->shouldReceive('activityLog');

        $moduleUtil = Mockery::mock(ModuleUtil::class);
        $moduleUtil->shouldReceive('hasThePermissionInSubscription')->andReturn(true);

        $controller = new LoginController($businessUtil, $moduleUtil);

        $user = new User([
            'id' => 1,
            'username' => 'user',
            'status' => 'active',
            'allow_login' => 1,
            'user_type' => 'user',
            'business_id' => 1,
            'two_factor_secret' => 'JBSWY3DPEHPK3PXP',
        ]);
        $user->setRelation('business', (object) ['is_active' => 1]);

        $request = Request::create('/login', 'POST');

        $response = $controller->authenticated($request, $user);

        $this->assertEquals(route('two-factor.challenge'), $response->headers->get('Location'));
    }
}
