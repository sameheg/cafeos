<?php

namespace Modules\Franchise\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Concerns\BelongsToTenant;

class Franchise extends Model
{
    use HasFactory, HasTranslations, BelongsToTenant;

    protected array $translatable = ['name', 'description'];

    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'description',
        'fee',
    ];
}
