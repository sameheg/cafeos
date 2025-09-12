<?php

declare(strict_types=1);

namespace Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Campaign extends Model
{
    use HasUlids;

    protected $table = 'crm_campaigns';

    protected $fillable = [
        'tenant_id',
        'segment_id',
        'status',
        'redemption_rate',
    ];

    protected $casts = [
        'redemption_rate' => 'float',
    ];

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }
}
