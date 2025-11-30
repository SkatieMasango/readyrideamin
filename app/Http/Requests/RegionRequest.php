<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255', 'unique:regions,name'],
            'is_enabled' => ['nullable', 'boolean'],
            'currency' => ['required', 'string', 'size:3', 'exists:currencies,currency_code'], // Ensure it's a valid 3-letter currency code
            'polygon_coordinates' => ['required', 'json'], // Ensure it's a valid JSON string
        ];
    }

    public function messages(): array
    {
        return [
            'polygon_coordinates.json' => 'The polygon coordinates must be a valid JSON string.',
        ];
    }
}
