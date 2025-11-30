<?php

namespace App\Http\Requests;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;

class NumberVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $country = Country::where('phone_code', $this->country_code)->select('code')->first();

        if (!$country) {
            return [
                'country_code' => 'required|string|exists:countries,phone_code',
            ];
        }

        $countryCode = strtoupper($country->code); // ISO format, e.g., 'BE', 'IN'
        $this['country_iso'] = $countryCode;
        return [
            'mobile' => [
                'required',
                // 'phone:' . $countryCode,
            ],
            'country_code' => 'required|string|exists:countries,phone_code',
        ];
    }

    /**
     * Custom error messages for the validation rules above.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
                'mobile.required' => 'The mobile number is required.',
                'mobile.phone' => 'The phone number is not valid for the selected country.',
            ];
    }
}
