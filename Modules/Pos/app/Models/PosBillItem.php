<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosBillItem extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','bill_id','order_item_id','qty','price','line_total'];
    public function bill(){ return $this->belongsTo(PosBill::class, 'bill_id'); }
    public function orderItem(){ return $this->belongsTo(PosItem::class, 'order_item_id'); }
}
