<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class ProfessionalInfoRequest extends FormRequest
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
            'vehicle_type' => 'required|string',
            'vehicle_color' => 'required|string',
            'vehicle_plate' => 'required|string',
            'vehicle_regi_year' => 'required|string',
            'documents.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            // 'nid' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'license' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'vehicle_paper' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];

    }
}
