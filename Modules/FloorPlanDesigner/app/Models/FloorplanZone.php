<?php

namespace Modules\FloorPlanDesigner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class FloorplanZone extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'name',
        'coords',
    ];

    protected $casts = [
        'coords' => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(Floorplan::class, 'plan_id');
    }
}
