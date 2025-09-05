<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosEditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'changes',
        'edited_at',
    ];

    protected $casts = [
        'changes' => 'array',
        'edited_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
