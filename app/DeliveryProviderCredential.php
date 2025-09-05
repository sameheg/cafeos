<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryProviderCredential extends Model
{
    protected $fillable = [
        'provider',
        'business_id',
        'token',
        'secret',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Retrieve credentials for the given provider and optional business.
     */
    public static function for(string $provider, ?int $businessId = null): ?self
    {
        $query = static::where('provider', $provider);

        if (! is_null($businessId)) {
            $query->where('business_id', $businessId);
        }

        return $query->first();
    }
}
