<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    protected $fillable = [
        'label',
        'url',
        'icon',
        'permission',
        'order',
    ];
}
