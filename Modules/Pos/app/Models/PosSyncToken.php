<?php

namespace Modules\Pos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PosSyncToken extends Model
{
    use HasUlids;
    protected $fillable = ['tenant_id','device_id','last_token'];
}
