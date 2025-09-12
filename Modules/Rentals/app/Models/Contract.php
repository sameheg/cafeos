<?php

namespace Modules\Rentals\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    protected $table = 'rentals_contracts';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tenant_id',
        'listing_id',
        'renter_id',
        'end_date',
        'status',
    ];

    protected $casts = [
        'end_date' => 'date',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function markDisputed(): void
    {
        $this->update(['status' => 'disputed']);
    }
}
