<?php

namespace Modules\FloorPlanDesigner\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class FloorLayout extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'layout'];

    protected $casts = [
        'layout' => 'array',
    ];
}
