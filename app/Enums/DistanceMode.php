<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum DistanceMode: string
{
    use EnumAttributes;

    case PICKUP_TO_DESTINATION = 'pickup_to_destination';
    case ZONE_BASED = 'zone_based';


    public function label(): string
    {
        return match ($this) {
            self::PICKUP_TO_DESTINATION => 'Pickup to Destination',
            self::ZONE_BASED => 'Zone Based',
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
