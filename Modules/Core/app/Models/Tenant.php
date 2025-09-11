<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function domains()
    {
        return $this->hasMany(TenantDomain::class);
    }

    public function modules()
    {
        return $this->hasMany(ModuleRegistry::class);
    }
}
