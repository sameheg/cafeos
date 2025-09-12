<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'jobs_postings';

    protected $fillable = [
        'tenant_id',
        'title',
        'status',
    ];

    public const STATUS_OPEN = 'open';

    public const STATUS_CLOSED = 'closed';

    protected static function newFactory()
    {
        return \Modules\Jobs\Database\Factories\JobPostingFactory::new();
    }
}
