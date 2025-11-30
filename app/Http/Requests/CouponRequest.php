<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code' => 'required|string|unique:coupons,code|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_users' => 'required|integer|min:0',
            'max_uses_per_user' => 'required|integer|min:1',
            'minimum_cost' => 'required|numeric|min:0',
            'maximum_cost' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_till' => 'nullable|date|after_or_equal:valid_from',
            // Ensure at least one discount field is provided
            'discount_percent' => 'nullable|integer|min:0|max:100|required_without_all:discount_flat,credit_gift',
            'discount_flat' => 'nullable|numeric|min:0|required_without_all:discount_percent,credit_gift',
            'credit_gift' => 'nullable|numeric|min:0|required_without_all:discount_percent,discount_flat',

            'is_enabled' => 'required|boolean',
            'is_first_travel_only' => 'required|boolean',
        ];
    }

    /**
     * Customize the error messages.
     */
    public function messages()
    {
        return [
            'code.required' => 'Coupon code is required.',
            'code.unique' => 'This coupon code is already in use.',
            'valid_till.after_or_equal' => 'Expiration date must be after or equal to the start date.',
            'discount_percent.max' => 'Discount percentage cannot be more than 100%.',
        ];
    }
}
