<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pickup_location' => 'required|array',
            'drop_location' => 'required|array',
            'wait_location' => 'nullable|array',
            'service_option_ids' => 'nullable|array',
            'coupon_code' => 'nullable|string',
        ];
    }
}
