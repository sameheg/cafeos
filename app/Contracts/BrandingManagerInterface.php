<?php

namespace App\Contracts;

interface BrandingManagerInterface
{
    public function setBranding(int|string $tenantId, array $branding): void;

    public function getBranding(int|string $tenantId): array;
}
