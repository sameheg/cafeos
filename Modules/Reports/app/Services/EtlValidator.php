<?php

namespace Modules\Reports\Services;

use Laravel\Pennant\Feature;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EtlValidator
{
    public function validate(array $data): void
    {
        if (! Feature::active('reports_etl_validation')) {
            return;
        }

        $validator = Validator::make($data, [
            'values' => 'required|array',
            'values.*' => 'numeric',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
