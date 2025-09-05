<?php

namespace Modules\Superadmin\Entities;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['tenant_id', 'subscription_id', 'amount', 'gateway', 'status', 'paid_at'];
    protected $dates = ['paid_at'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
