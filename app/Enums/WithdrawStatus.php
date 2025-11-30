<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum WithdrawStatus: string
{
    use EnumAttributes;

    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';


/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * The human-readable label for the given withdraw status
     *
     * @return string
     */
/*******  4e9930f2-8cb7-442b-b72f-c3901aa33120  *******/    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
            self::REJECTED => 'Rejected',
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
