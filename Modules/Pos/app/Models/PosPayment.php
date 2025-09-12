<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosPayment extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','order_id','method','amount','status','meta'];
    protected $casts = ['meta'=>'array'];
    public function order(){ return $this->belongsTo(PosOrder::class, 'order_id'); }
}
