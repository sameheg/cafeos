<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'primary_color',
        'secondary_color',
        'logo',
        'font',
        'layout',
    ];
}

