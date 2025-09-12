<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosBill extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','order_id','label','subtotal','tax_amount','service_amount','discount_total','total','paid_total','outstanding_total'];
    public function items(){ return $this->hasMany(PosBillItem::class, 'bill_id'); }
    public function order(){ return $this->belongsTo(PosOrder::class, 'order_id'); }
}
