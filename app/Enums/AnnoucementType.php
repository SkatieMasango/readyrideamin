<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum AnnoucementType: string
{
    use EnumAttributes;

    case ALL = 'all';
    case DRIVERS = 'drivers';
    case RIDERS = 'riders';

    public function label(): string
    {
        return match ($this) {
            self::ALL => 'All',
            self::DRIVERS => 'Drivers',
            self::RIDERS => 'Riders',
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
