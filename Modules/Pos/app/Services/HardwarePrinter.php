<?php

namespace Modules\Pos\Services;

class HardwarePrinter
{
    public static function printRaw(string $endpoint, string $raw): bool
    {
        // endpoint "ip:port"
        [$host, $port] = explode(':', $endpoint) + [null, 9100];
        $port = $port ?: 9100;
        $fp = @fsockopen($host, (int)$port, $errno, $errstr, 2.0);
        if (!$fp) return false;
        fwrite($fp, $raw);
        fclose($fp);
        return true;
    }

    public static function openDrawerRaw(string $endpoint): bool
    {
        // ESC/POS pulse command to kick drawer
        $pulse = chr(27).chr(112).chr(0).chr(25).chr(250);
        return self::printRaw($endpoint, $pulse);
    }
}
