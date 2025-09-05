<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceTemplate extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'field_toggles' => 'array',
    ];
}
