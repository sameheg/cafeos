<?php

declare(strict_types=1);

namespace Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Customer extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $table = 'crm_customers';

    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'rfm_score',
    ];

    protected $casts = [
        'rfm_score' => 'integer',
    ];
}
