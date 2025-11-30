<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum ComplaintStatus: string
{
    use EnumAttributes;


    case RESOLVED = 'resolved'; // order created by rider
    case UNDER_INVESTIGATION = 'under_investigation';


    public function label(): string
    {
        return match ($this) {
            self::RESOLVED => 'Resolved',
            self::UNDER_INVESTIGATION => 'Under Investigation',
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
