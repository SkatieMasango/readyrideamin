<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum SmsType: string
{
    use EnumAttributes;

    case TWILIO = 'twilio';
    case TELESIGN = 'telesign';
    case NEXMO = 'nexmo';
    case MESSAGEBIRD = 'messagebird';

    public static function cashAndCredit(): array
    {
        return [
            self::MESSAGEBIRD,
            self::NEXMO,
            self::TELESIGN,
            self::TWILIO,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::MESSAGEBIRD => 'Message Bird',
            self::NEXMO => 'Nexmo',
            self::TELESIGN => 'Telesign',
            self::TWILIO => 'Twilio',
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
