<?php

namespace Modules\Rentals\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Concerns\BelongsToTenant;

class Listing extends Model
{
    use HasFactory, HasTranslations, BelongsToTenant;

    /**
     * The attributes that are translatable.
     *
     * @var list<string>
     */
    protected array $translatable = ['title', 'description'];

    protected $fillable = [
        'tenant_id',
        'user_id',
        'type',
        'title',
        'description',
        'price',
    ];
}
