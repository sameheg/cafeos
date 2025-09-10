<?php

namespace Modules\Crm\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyResponse extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'survey_id',
        'branch_id',
        'rating',
        'comment',
    ];
}
