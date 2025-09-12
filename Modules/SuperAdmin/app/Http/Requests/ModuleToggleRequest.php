<?php

namespace Modules\SuperAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleToggleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'module' => 'required|string',
            'enabled' => 'required|boolean',
            'tenant_id' => 'nullable|uuid',
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('global_kill') ?? false;
    }
}
