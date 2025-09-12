<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosItemModifier extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','item_id','name','price','meta'];
    protected $casts = ['meta'=>'array'];
    public function item(){ return $this->belongsTo(PosItem::class, 'item_id'); }
}
