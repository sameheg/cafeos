<?php

namespace Modules\SuperAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BroadcastRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('broadcast') ?? false;
    }
}
