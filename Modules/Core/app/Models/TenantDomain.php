<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Traits\BelongsToTenant;

class TenantDomain extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $guarded = [];
}
