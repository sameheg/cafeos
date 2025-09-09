<?php

namespace Modules\FloorPlanDesigner\Models;

use Illuminate\Database\Eloquent\Model;

class FloorLayout extends Model
{
    protected $fillable = ['tenant_id', 'layout'];

    protected $casts = [
        'layout' => 'array',
    ];
}

