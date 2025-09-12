<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;

class PosTable extends Model
{
    protected $fillable = [
        'tenant_id','floorplan_id','furniture_id','name','capacity','status','current_order_id'
    ];

    public function floorplan() {
        return $this->belongsTo(\Modules\FloorPlanDesigner\Models\Floorplan::class);
    }

    public function order() {
        return $this->belongsTo(PosOrder::class, 'current_order_id');
    }
}
