<?php

namespace App\Restaurant;

use Illuminate\Database\Eloquent\Model;

class WaiterShift extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $dates = ['start_at', 'end_at'];
}
