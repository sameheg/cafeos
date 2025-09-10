<?php

namespace Modules\Pos\Services;

use DateTimeInterface;

class DynamicPricingService
{
    /**
     * @var array<int, array<string, mixed>>
     */
    protected array $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Calculate the price after applying dynamic rules based on time, day and customer.
     */
    public function calculate(float $basePrice, ?string $customer = null, ?DateTimeInterface $at = null): float
    {
        $price = $basePrice;
        $at = $at ?? new \DateTimeImmutable;

        foreach ($this->rules as $rule) {
            switch ($rule['type'] ?? '') {
                case 'time':
                    $start = \DateTimeImmutable::createFromFormat('H:i', $rule['start'] ?? '') ?: null;
                    $end = \DateTimeImmutable::createFromFormat('H:i', $rule['end'] ?? '') ?: null;
                    $time = \DateTimeImmutable::createFromFormat('H:i', $at->format('H:i'));
                    if ($start && $end && $time >= $start && $time <= $end) {
                        $price *= $rule['multiplier'];
                    }
                    break;
                case 'day':
                    $days = $rule['days'] ?? [];
                    $day = $at->format('l');
                    if (in_array($day, $days, true)) {
                        $price *= $rule['multiplier'];
                    }
                    break;
                case 'customer':
                    if (($rule['customer'] ?? null) === $customer) {
                        $price *= $rule['multiplier'];
                    }
                    break;
            }
        }

        return $price;
    }
}
