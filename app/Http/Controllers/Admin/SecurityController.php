<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class SecurityController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $enforced = Role::where('two_factor_required', true)->pluck('id')->toArray();

        return view('admin.security.2fa', [
            'roles' => $roles,
            'enforced' => $enforced,
        ]);
    }

    public function enableTwoFactor(Request $request)
    {
        $user = $request->user();
        if (empty($user->two_factor_secret)) {
            $user->two_factor_secret = $this->generateSecret();
            $user->two_factor_recovery_codes = json_encode($this->generateRecoveryCodes());
        }
        $user->two_factor_enabled = true;
        $user->save();

        return back()->with('status', __('Two-factor authentication enabled.'));
    }

    public function disableTwoFactor(Request $request)
    {
        $user = $request->user();
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_enabled = false;
        $user->save();

        return back()->with('status', __('Two-factor authentication disabled.'));
    }

    public function updateRoleRequirement(Request $request)
    {
        $roles = $request->input('roles', []);
        Role::query()->update(['two_factor_required' => false]);
        if (! empty($roles)) {
            Role::whereIn('id', $roles)->update(['two_factor_required' => true]);
        }

        return back()->with('status', __('Two-factor settings updated.'));
    }

    private function generateSecret($length = 16)
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }
        return $secret;
    }

    private function generateRecoveryCodes($count = 8)
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = Str::random(10);
        }
        return $codes;
    }
}
