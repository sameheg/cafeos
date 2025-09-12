<?php

namespace Modules\Franchise\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseBranch extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'franchise_branches';

    protected $fillable = [
        'tenant_id',
        'name',
        'overrides',
    ];

    protected $casts = [
        'overrides' => 'encrypted:array',
    ];
}
