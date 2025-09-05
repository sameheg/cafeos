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
}
