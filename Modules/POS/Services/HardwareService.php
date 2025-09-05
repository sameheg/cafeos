<?php

namespace Modules\POS\Services;

class HardwareService
{
    /**
     * Configured hardware devices.
     *
     * @var array
     */
    protected array $devices;

    public function __construct(?array $devices = null)
    {
        $this->devices = $devices ?? config('hardware.devices', []);
    }

    /**
     * Get device configuration by name.
     *
     * @throws \InvalidArgumentException
     */
    public function getDevice(string $name): array
    {
        if (! isset($this->devices[$name])) {
            throw new \InvalidArgumentException("Hardware device [{$name}] not configured.");
        }

        return $this->devices[$name];
    }

    /**
     * Build a printer instance using escpos-php when available.
     *
     * @return \Mike42\Escpos\Printer|null
     */
    public function printer(string $name)
    {
        $device = $this->getDevice($name);

        if (! class_exists(\Mike42\Escpos\Printer::class)) {
            return null; // Library not installed, return null for graceful degradation
        }

        $driver = $device['driver'] ?? 'FilePrintConnector';
        $port = $device['port'] ?? 'php://stdout';

        switch ($driver) {
            case 'NetworkPrintConnector':
                $connector = new \Mike42\Escpos\PrintConnectors\NetworkPrintConnector(
                    $device['host'] ?? '127.0.0.1',
                    $port
                );
                break;
            case 'WindowsPrintConnector':
                $connector = new \Mike42\Escpos\PrintConnectors\WindowsPrintConnector($port);
                break;
            default:
                $connector = new \Mike42\Escpos\PrintConnectors\FilePrintConnector($port);
        }

        return new \Mike42\Escpos\Printer($connector);
    }
}
