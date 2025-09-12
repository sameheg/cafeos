<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'billing_payments';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'tenant_id', 'invoice_id', 'method', 'status'];

    protected static function booted(): void
    {
        static::creating(function (Payment $payment) {
            if (! $payment->id) {
                $payment->id = (string) Str::ulid();
            }
        });
    }
}
