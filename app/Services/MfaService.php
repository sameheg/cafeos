<?php

namespace App\Services;

/**
 * Basic TOTP-based multi-factor authentication helper.
 */
class MfaService
{
    public function generateSecret(): string
    {
        return bin2hex(random_bytes(10));
    }

    public function getCurrentCode(string $secret): string
    {
        $time = floor(time() / 30);
        $binaryTime = pack('N*', 0) . pack('N*', $time);
        $hash = hash_hmac('sha1', $binaryTime, hex2bin($secret), true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncated = unpack('N', substr($hash, $offset, 4))[1] & 0x7fffffff;
        return str_pad((string) ($truncated % 1000000), 6, '0', STR_PAD_LEFT);
    }

    public function verify(string $secret, string $code): bool
    {
        return hash_equals($this->getCurrentCode($secret), $code);
    }
}
