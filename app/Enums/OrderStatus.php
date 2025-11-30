<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum OrderStatus: string
{
    use EnumAttributes;

    case PENDING = 'pending'; // order created by rider
    case ACCEPTED = 'accepted'; // accept by a driver
    case REJECTED = 'rejected'; // reject by a driver
    case GO_TO_PICKUP = 'go_to_pickup'; // picking up in progress by a driver
    case CONFIRM_ARRIVAL = 'confirm_arrival'; // picking up in progress by a driver
    case PICKED_UP = 'picked_up'; // picked up by a driver
    case START_RIDE = 'start_ride'; // picking up in progress by a driver
    case STOP_POINT = 'stop_point'; // ride ongoing by driver  ----------------now it is not usable
    case IN_PROGRESS = 'in_progress'; // ride ongoing by driver   ----------------now it is not usable
    case WAITING = 'waiting'; // ride is waiting due to some needs ----------------now it is not usable
    case DROPPED_OFF = 'dropped_off'; // ride ongoing by driver
    case COMPLETED = 'completed'; // ride completed by driver
    case CANCELLED = 'cancelled'; // cancelled by rider


    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
            self::GO_TO_PICKUP => 'Go To Pickup',
            self::CONFIRM_ARRIVAL => 'Confirm Arrival',
            self::PICKED_UP => 'Picked Up',
            self::START_RIDE => 'Start Ride',
            self::STOP_POINT => 'Stop Point',
            self::IN_PROGRESS => 'In Progress',
            self::WAITING => 'Waiting',
            self::DROPPED_OFF => 'Dropped Off',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
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

