<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum DiscountType: string
{
    use EnumAttributes;

    case PERCENTAGE = 'percentage';
    case FLAT = 'flat';

    public function label(): string
    {
        return match ($this) {
            self::PERCENTAGE => 'Percentage',
            self::FLAT => 'Flat',

        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => [
                'value' => $case->value,
                'name' => $case->label(),
            ]];
        })->toArray();
    }
}
