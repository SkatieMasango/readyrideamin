<?php

namespace App\Enums;

use App\Enums\Attributes\EnumAttributes;

enum SOSStatus: string
{
    use EnumAttributes;

    case SUBMITTED = 'submitted';
    case RESOLVED = 'resolved';
    case CANCELLED = 'cancelled';
}
