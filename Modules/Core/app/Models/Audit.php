<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Traits\BelongsToTenant;

class Audit extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'user_id', 'action', 'path'];
}
