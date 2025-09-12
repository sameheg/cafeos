<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosCustomer extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','name','phone','email','meta'];
    protected $casts = ['meta'=>'array'];
}
