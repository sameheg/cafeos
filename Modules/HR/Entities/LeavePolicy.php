<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class LeavePolicy extends Model
{
    protected $fillable = [
        'name',
        'days',
        'description',
    ];
}
