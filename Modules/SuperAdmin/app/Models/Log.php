<?php

namespace Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'superadmin_logs';

    public $timestamps = false;

    protected $fillable = ['action', 'user_id', 'timestamp', 'meta'];

    protected $casts = [
        'timestamp' => 'datetime',
        'meta' => 'array',
    ];
}
