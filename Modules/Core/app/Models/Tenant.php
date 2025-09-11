<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelFlags\Models\Concerns\HasFlags;

class Tenant extends Model
{
    use HasFactory, HasFlags;

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
