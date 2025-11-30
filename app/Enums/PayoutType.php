<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum PayoutType: string
{
    use EnumAttributes;

    case CASH = 'cash';
    case STRIPE = 'stripe';
    case BANK_TRANSFER = 'bank_transfer';
    // case CREDIT = 'credit';
    // case BOTH = 'both';


    public static function cashAndCredit(): array
    {
        return [
            self::CASH,
            self::BANK_TRANSFER,
            self::STRIPE,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::BANK_TRANSFER => 'Bank Transfer',
            self::STRIPE => 'Stripe',
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
