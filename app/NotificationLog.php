<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the contact related to the log.
     */
    public function contact()
    {
        return $this->belongsTo(\App\Contact::class);
    }
}
