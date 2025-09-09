<?php

namespace Modules\Kds\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
