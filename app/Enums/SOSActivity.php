<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum SOSActivity: string
{
    use EnumAttributes;

    case CONTACTDRIVER = 'contacted the driver';
    case CONTACTAUTHORITIES = 'contacted the authorities';
    case MARKRESOLVED = 'marked as resolved';
    case MARKALARM = 'marked as false alarm';

    public function label(): string
    {
        return match ($this) {
            self::CONTACTDRIVER => 'Contacted the driver',
            self::CONTACTAUTHORITIES => 'Contacted the authorities',
            self::MARKRESOLVED => 'Marked as resolved',
            self::MARKALARM => 'Marked as false alarm',
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
