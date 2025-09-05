<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TwoFactorController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (empty($user->two_factor_secret)) {
            $user->two_factor_secret = $this->generateSecret();
            $user->two_factor_recovery_codes = json_encode($this->generateRecoveryCodes());
        }
        $user->two_factor_enabled = true;
        $user->save();

        $codes = json_decode($user->two_factor_recovery_codes, true) ?? [];

        return view('auth.two-factor.index', [
            'secret' => $user->two_factor_secret,
            'recoveryCodes' => $codes,
        ]);
    }

    public function disable(Request $request)
    {
        $user = $request->user();
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_enabled = false;
        $user->save();

        return back()->with('status', __('Two-factor authentication disabled.'));
    }

    public function showChallenge()
    {
        return view('auth.two-factor.challenge');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $user = $request->user();

        if ($this->verifyCode($user->two_factor_secret, $request->code)) {
            $request->session()->put('two_factor_passed', true);
            return redirect()->intended('/home');
        }

        return back()->withErrors(['code' => __('Invalid authentication code.')]);
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

    private function verifyCode($secret, $code)
    {
        return $this->getOtp($secret) === $code;
    }

    private function getOtp($secret, $timeSlice = null)
    {
        $timeSlice = $timeSlice ?? floor(time() / 30);
        $secretKey = $this->base32Decode($secret);
        $time = pack('N*', 0) . pack('N*', $timeSlice);
        $hash = hash_hmac('sha1', $time, $secretKey, true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncatedHash = unpack('N', substr($hash, $offset, 4))[1] & 0x7fffffff;
        $otp = $truncatedHash % 1000000;
        return str_pad($otp, 6, '0', STR_PAD_LEFT);
    }

    private function base32Decode($secret)
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = strtoupper($secret);
        $binaryString = '';
        foreach (str_split($secret) as $char) {
            $pos = strpos($alphabet, $char);
            if ($pos === false) {
                continue;
            }
            $binaryString .= str_pad(decbin($pos), 5, '0', STR_PAD_LEFT);
        }
        $bytes = str_split($binaryString, 8);
        $result = '';
        foreach ($bytes as $byte) {
            if (strlen($byte) === 8) {
                $result .= chr(bindec($byte));
            }
        }
        return $result;
    }
}
