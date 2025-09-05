<?php

namespace Modules\Superadmin\Entities;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['tenant_id', 'plan_id', 'starts_at', 'ends_at', 'status'];
    protected $dates = ['starts_at', 'ends_at'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
