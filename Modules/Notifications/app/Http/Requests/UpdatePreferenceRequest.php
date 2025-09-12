<?php

namespace Modules\Notifications\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreferenceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'channel' => ['required', 'string'],
            'opt_out' => ['required', 'boolean'],
        ];
    }
}
