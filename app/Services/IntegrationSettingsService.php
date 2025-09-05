<?php

namespace App\Services;

use App\Models\IntegrationSetting;

class IntegrationSettingsService
{
    public function get(string $service, string $key, $default = null): ?string
    {
        return IntegrationSetting::where('service', $service)
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    public function set(string $service, string $key, $value): IntegrationSetting
    {
        return IntegrationSetting::updateOrCreate(
            ['service' => $service, 'key' => $key],
            ['value' => $value]
        );
    }

    public function all(): array
    {
        return IntegrationSetting::all()
            ->groupBy('service')
            ->map(function ($group) {
                return $group->pluck('value', 'key')->toArray();
            })->toArray();
    }

    public function getService(string $service): array
    {
        return IntegrationSetting::where('service', $service)
            ->pluck('value', 'key')->toArray();
    }
}
