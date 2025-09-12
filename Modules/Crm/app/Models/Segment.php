<?php

declare(strict_types=1);

namespace Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Segment extends Model
{
    use HasUlids;

    protected $table = 'crm_segments';

    protected $fillable = [
        'tenant_id',
        'name',
        'criteria',
    ];

    protected $casts = [
        'criteria' => 'array',
    ];
}
