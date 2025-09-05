<?php

namespace Modules\Superadmin\Entities;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'price', 'interval', 'features'];
    protected $casts = ['features' => 'array'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
