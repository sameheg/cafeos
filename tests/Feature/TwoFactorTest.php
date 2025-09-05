<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SecurityController;
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
        $controller = new SecurityController();

        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('save')->once()->andReturnTrue();

        $request = Request::create('/admin/security/2fa/enable', 'POST');
        $request->setUserResolver(fn () => $user);

        $controller->enableTwoFactor($request);

        $this->assertNotEmpty($user->two_factor_secret);
        $this->assertNotEmpty($user->two_factor_recovery_codes);
        $this->assertTrue($user->two_factor_enabled);
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
            'two_factor_enabled' => true,
        ]);
        $user->setRelation('business', (object) ['is_active' => 1]);
        $user->setRelation('roles', collect());

        $request = Request::create('/login', 'POST');

        $response = $controller->authenticated($request, $user);

        $this->assertEquals(route('two-factor.challenge'), $response->headers->get('Location'));
    }

    public function test_login_redirects_to_setup_when_role_requires_two_factor()
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
            'two_factor_enabled' => false,
        ]);
        $user->setRelation('business', (object) ['is_active' => 1]);
        $user->setRelation('roles', collect([(object) ['two_factor_required' => true]]));

        $request = Request::create('/login', 'POST');

        $response = $controller->authenticated($request, $user);

        $this->assertEquals(route('admin.security.2fa'), $response->headers->get('Location'));
    }
}
