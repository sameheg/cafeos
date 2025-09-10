<?php

namespace Modules\HrJobs\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends TenantModel
{
    protected $fillable = [
        'tenant_id',
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
