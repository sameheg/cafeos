<?php

namespace Modules\Pos\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableLayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'layout',
    ];

    protected $casts = [
        'layout' => 'array',
    ];
}
