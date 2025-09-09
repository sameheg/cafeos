<?php

namespace Modules\Membership\Enums;

enum MembershipTier: string
{
    case BRONZE = 'bronze';
    case SILVER = 'silver';
    case GOLD = 'gold';

    public function discount(): float
    {
        return match ($this) {
            self::BRONZE => 0.0,
            self::SILVER => 0.05,
            self::GOLD => 0.1,
        };
    }

    public function benefits(): array
    {
        return match ($this) {
            self::BRONZE => ['basic support'],
            self::SILVER => ['priority support', '5% discount'],
            self::GOLD => ['priority support', '10% discount', 'free upgrades'],
        };
    }

    public function priority(): int
    {
        return match ($this) {
            self::BRONZE => 0,
            self::SILVER => 1,
            self::GOLD => 2,
        };
    }

    public function next(): self
    {
        return match ($this) {
            self::BRONZE => self::SILVER,
            self::SILVER => self::GOLD,
            self::GOLD => self::GOLD,
        };
    }

    public function previous(): self
    {
        return match ($this) {
            self::BRONZE => self::BRONZE,
            self::SILVER => self::BRONZE,
            self::GOLD => self::SILVER,
        };
    }

    public function pointsMultiplier(): float
    {
        return match ($this) {
            self::BRONZE => 1.0,
            self::SILVER => 1.1,
            self::GOLD => 1.25,
        };
    }
}
