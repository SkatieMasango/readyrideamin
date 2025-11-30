<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsRequest extends FormRequest
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
            'site_name' => 'required|string|max:255',
            'site_title' => 'nullable|string|max:255',
            'currency' => 'required|string|max:10',
            'currency_position' => 'required',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'required|string|max:20',
            'site_address' => 'nullable|string|max:500',
            'website_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:512',
            'android_app_link' => 'nullable|url',
            'ios_app_link' => 'nullable|url',
        ];
    }
}
