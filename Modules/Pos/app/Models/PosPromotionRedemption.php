<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosPromotionRedemption extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','promotion_id','order_id','discount_amount','code_used'];
    public function promotion(){ return $this->belongsTo(PosPromotion::class, 'promotion_id'); }
}
