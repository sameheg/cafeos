<?php

namespace Modules\ArMenu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ArInteraction extends Model
{
    use HasUlids;

    protected $table = 'ar_interactions';

    public $timestamps = false;

    protected $fillable = [
        'tenant_id', 'asset_id', 'timestamp'
    ];
}
