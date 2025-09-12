<?php

namespace Modules\Rentals\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $table = 'rentals_listings';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tenant_id',
        'name',
        'status',
    ];
}
