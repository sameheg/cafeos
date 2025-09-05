<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduledTask extends Model
{
    protected $fillable = [
        'command',
        'frequency',
        'enabled',
    ];
}
