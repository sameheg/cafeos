<?php

namespace Modules\FloorPlanDesigner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateFloorplanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Policy hooks can be added
    }

    public function rules(): array
    {
        return [
            'json_data' => ['required', 'array'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(['message' => 'Invalid JSON'], 400));
    }
}
