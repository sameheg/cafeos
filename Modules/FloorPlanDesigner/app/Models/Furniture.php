<?php

namespace Modules\FloorPlanDesigner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Furniture extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'floorplan_furniture';

    protected $fillable = [
        'tenant_id','plan_id','type','name','capacity','status',
        'x','y','w','h','r','layer','pos_table_id','meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(Floorplan::class, 'plan_id');
    }
}
