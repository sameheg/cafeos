<?php

namespace Modules\Franchise\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Franchise extends Model
{
    use HasFactory, HasTranslations;

    protected array $translatable = ['name', 'description'];

    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'description',
        'fee',
    ];
}
