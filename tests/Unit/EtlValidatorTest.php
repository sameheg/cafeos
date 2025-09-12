<?php

namespace Tests\Unit;

use Illuminate\Validation\ValidationException;
use Laravel\Pennant\Feature;
use Modules\Reports\Services\EtlValidator;
use Tests\TestCase;

class EtlValidatorTest extends TestCase
{
    public function test_validation_enforced_when_feature_active(): void
    {
        Feature::activate('reports_etl_validation');

        $validator = new EtlValidator();
        $this->expectException(ValidationException::class);
        $validator->validate(['values' => ['a']]);
    }

    public function test_validation_skipped_when_feature_inactive(): void
    {
        Feature::deactivate('reports_etl_validation');

        $validator = new EtlValidator();
        $validator->validate(['values' => ['a']]);
        $this->addToAssertionCount(1);
    }
}
