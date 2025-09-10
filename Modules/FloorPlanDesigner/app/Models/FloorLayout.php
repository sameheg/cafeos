<?php

namespace Modules\FloorPlanDesigner\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;

class FloorLayout extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'layout'];

    protected $casts = [
        'layout' => 'array',
    ];
}

