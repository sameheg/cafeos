<?php

namespace App\Listeners;

use Spatie\Permission\PermissionRegistrar;

class SetPermissionsTeam
{
    public function handle(): void
    {
        app(PermissionRegistrar::class)->setPermissionsTeamId(tenant('id'));
    }
}
