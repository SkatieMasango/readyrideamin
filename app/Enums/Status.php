<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum Status: string
{
    use EnumAttributes;


    case PENDING_APPROVAL = 'pending_approval'; // order created by rider
    case APPROVED = 'approved';
    case BLOCKED = 'blocked';

    public function label(): string
    {
        return match ($this) {
            self::PENDING_APPROVAL => 'Pending Approval',
            self::APPROVED => 'Approved',
            self::BLOCKED => 'Blocked',

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
        public static function optionsWithout(string|array $exclude): array
    {
        $exclude = (array) $exclude;

        return collect(self::options())
            ->reject(fn($label, $key) => in_array($key, $exclude))
            ->toArray();
    }
}
