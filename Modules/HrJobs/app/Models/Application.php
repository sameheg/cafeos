<?php

namespace Modules\HrJobs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'job_id',
        'member_profile_id',
        'resume',
        'status',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function memberProfile(): BelongsTo
    {
        return $this->belongsTo('Modules\\Membership\\Models\\MemberProfile');
    }
}
