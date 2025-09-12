<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosDiscount extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','order_id','scope','amount','percent','code','meta'];
    protected $casts = ['meta'=>'array'];
    public function order(){ return $this->belongsTo(PosOrder::class, 'order_id'); }
}
