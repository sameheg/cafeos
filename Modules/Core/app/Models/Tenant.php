<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'subdomain',
    ];

    protected $casts = [];

    public static function current(): ?self
    {
        return app('tenant');
    }
}
