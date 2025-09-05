<?php

namespace App\Restaurant;

use Illuminate\Database\Eloquent\Model;

class TableAssignment extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $dates = ['assigned_at', 'released_at'];
}
