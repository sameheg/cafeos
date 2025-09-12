<?php

namespace Modules\Core\Filament\Resources\FeatureFlagResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Modules\Core\Filament\Resources\FeatureFlagResource;

class ManageFeatureFlags extends ManageRecords
{
    protected static string $resource = FeatureFlagResource::class;
}
