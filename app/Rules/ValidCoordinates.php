<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCoordinates implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            $fail('The :attribute must be an array with lat and lng.');

            return;
        }

        if (! isset($value['lat']) || ! isset($value['lng'])) {
            $fail('The :attribute must contain both lat and lng values.');

            return;
        }
        if (! is_numeric($value['lat'])) {
            $fail('The latitude must be a number.');

            return;
        }

        if ($value['lat'] < -90 || $value['lat'] > 90) {
            $fail('The latitude must be between -90 and 90 degrees.');

            return;
        }

        if (! is_numeric($value['lng'])) {
            $fail('The longitude must be a number.');

            return;
        }

        if ($value['lng'] < -180 || $value['lng'] > 180) {
            $fail('The longitude must be between -180 and 180 degrees.');

            return;
        }

        if ($value['lat'] == 0 && $value['lng'] == 0) {
            $fail('Null Island coordinates (0,0) are not allowed.');
        }
    }
}
