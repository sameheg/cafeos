<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class JobApplication extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'jobs_applications';

    protected $fillable = [
        'tenant_id',
        'posting_id',
        'cv_path',
        'status',
    ];

    public const STATUS_APPLIED = 'applied';

    public const STATUS_SCREENED = 'screened';

    public const STATUS_HIRED = 'hired';

    public const STATUS_REJECTED = 'rejected';

    public function posting()
    {
        return $this->belongsTo(JobPosting::class, 'posting_id');
    }

    public function screen(): void
    {
        $this->update(['status' => self::STATUS_SCREENED]);
    }

    public function hire(): void
    {
        $this->update(['status' => self::STATUS_HIRED]);
    }

    public function reject(): void
    {
        Storage::delete($this->cv_path);
        $this->update(['status' => self::STATUS_REJECTED]);
        $this->delete();
    }

    protected static function newFactory()
    {
        return \Modules\Jobs\Database\Factories\JobApplicationFactory::new();
    }
}
