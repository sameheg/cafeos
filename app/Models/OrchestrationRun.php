<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrchestrationRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan',
        'status',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'plan' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}

