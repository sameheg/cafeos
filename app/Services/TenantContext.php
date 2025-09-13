<?php

namespace App\Services;

use App\Models\Tenant;

class TenantContext
{
    private ?Tenant $tenant = null;

    /** @var array<string, mixed> */
    private array $settings = [];

    public function setTenant(Tenant $tenant): void
    {
        $this->tenant = $tenant;
        $this->settings = array_merge(
            config('tenant.defaults', []),
            $tenant->settings ?? []
        );

        $posOverrides = $tenant->settings['pos'] ?? [];
        config(['pos' => array_replace_recursive(config('pos', []), $posOverrides)]);
    }

    public function tenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settings[$key] ?? $default;
    }

    /**
     * Get all tenant settings.
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->settings;
    }
}

