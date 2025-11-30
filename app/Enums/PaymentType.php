<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum PaymentType: string
{
    use EnumAttributes;

    case RAZORPAY = 'razorpay';
    case STRIPE = 'stripe';
    case PAYSTACK = 'paystack';
    case PAYFAST = 'payfast';
    case CASH = 'cash';
    // case BOTH = 'both';


    public static function cashAndCredit(): array
    {
        return [
            self::RAZORPAY,
            self::PAYSTACK,
            self::STRIPE,
            self::PAYFAST,
            self::CASH,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::RAZORPAY => 'Razorpay',
            self::PAYSTACK => 'Paystack',
            self::STRIPE => 'Stripe',
            self::PAYFAST => 'Payfast',
            self::CASH => 'Cash',
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
