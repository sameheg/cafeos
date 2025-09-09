<?php

namespace Modules\TableReservations\Models;

use Illuminate\Database\Eloquent\Model;

class WaitlistEntry extends Model
{
    protected $fillable = ['customer_name', 'phone', 'party_size', 'status'];
}
