<?php

namespace Modules\FloorPlanDesigner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Carbon;

class Floorplan extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'json_data',
        'version',
        'scheduled_at',
        'state',
    ];

    protected $casts = [
        'json_data' => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function zones()
    {
        return $this->hasMany(FloorplanZone::class, 'plan_id');
    }

    public function publish(): void
    {
        $this->state = 'published';
        $this->save();
    }

    public function schedule(Carbon $time): void
    {
        $this->state = 'versioned';
        $this->scheduled_at = $time;
        $this->save();
    }

    public function archive(): void
    {
        $this->state = 'archived';
        $this->save();
    }
}
