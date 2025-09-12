<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;

class PosAudit extends Model
{
    protected $fillable = ['tenant_id','user_id','action','entity_type','entity_id','data'];
    protected $casts = ['data'=>'array'];
}
