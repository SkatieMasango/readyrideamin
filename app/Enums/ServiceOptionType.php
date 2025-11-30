<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum ServiceOptionType: string
{
    use EnumAttributes;

    case CASH = 'cash';
    case FREE = 'free';
    case TWO_WAY = 'two_way';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::FREE => 'Free',
            self::TWO_WAY => 'Two way',
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
