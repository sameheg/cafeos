<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenantModule extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'module',
        'enabled',
        'version',
        'constraints',
    ];

    protected $casts = [
        'enabled' => 'bool',
        'constraints' => 'array',
    ];
}
