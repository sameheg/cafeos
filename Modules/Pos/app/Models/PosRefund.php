<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosRefund extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','order_id','amount','reason','items'];
    protected $casts = ['items'=>'array'];
    public function order(){ return $this->belongsTo(PosOrder::class, 'order_id'); }
}
