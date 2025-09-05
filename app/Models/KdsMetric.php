<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KdsMetric extends Model
{
    protected $fillable = [
        'ticket_id',
        'prep_time_seconds',
        'queue_time_seconds',
    ];
}
