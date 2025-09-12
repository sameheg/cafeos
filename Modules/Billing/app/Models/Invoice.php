<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'billing_invoices';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'tenant_id', 'amount', 'status', 'due_date'];

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (! $invoice->id) {
                $invoice->id = (string) Str::ulid();
            }
        });

        static::created(function (Invoice $invoice) {
            event('billing.invoice.issued@v1', [
                'invoice_id' => $invoice->id,
                'amount' => $invoice->amount,
            ]);
        });
    }
}
