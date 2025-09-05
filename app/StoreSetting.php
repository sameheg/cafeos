<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'business_id',
        'theme',
    ];
}

