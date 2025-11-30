<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class PersonalInfoRequest extends FormRequest
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
            'name' => 'required|string',
            'emergency_contact' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'address' => 'required|string',
            'gender' => ['required', 'string', new Enum(Gender::class)],
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
