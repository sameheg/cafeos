<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosPromotionRule extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','promotion_id','type','value','conditions'];
    protected $casts = ['conditions'=>'array'];
    public function promotion(){ return $this->belongsTo(PosPromotion::class, 'promotion_id'); }
}
