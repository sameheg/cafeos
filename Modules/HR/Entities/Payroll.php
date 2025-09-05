<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'month',
        'status',
    ];
}
