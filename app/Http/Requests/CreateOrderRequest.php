<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'pickup_location' => 'required|array',
            'pickup_address' => 'required|string',
            'drop_location' => 'required|array',
            'drop_address' => 'required|string',
            'wait_location' => 'nullable|array',
            'wait_address' => 'nullable|string',
            'service_id' => 'required',
            'service_option_ids' => 'nullable|array',
            'coupon_code' => 'nullable|string',
            // 'payment_mode' => 'required',
        ];
    }
}
