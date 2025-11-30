<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum PaymentStatus: string
{
    use EnumAttributes;


    case ACTIVE = 'active'; // order created by rider
    case INACTIVE = 'in_active';


    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'In Active',
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
