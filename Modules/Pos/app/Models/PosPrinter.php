<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosPrinter extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','name','type','endpoint','meta'];
    protected $casts = ['meta'=>'array'];
}
