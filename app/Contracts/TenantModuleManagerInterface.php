<?php

namespace App\Contracts;

interface TenantModuleManagerInterface
{
    public function enableModule(int|string $tenantId, string $module): void;

    public function disableModule(int|string $tenantId, string $module): void;

    public function isModuleEnabled(int|string $tenantId, string $module): bool;
}
