<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosPromotion extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','name','code','active','starts_at','ends_at','meta'];
    protected $casts = ['meta'=>'array','starts_at'=>'datetime','ends_at'=>'datetime'];
    public function rules(){ return $this->hasMany(PosPromotionRule::class, 'promotion_id'); }
}
