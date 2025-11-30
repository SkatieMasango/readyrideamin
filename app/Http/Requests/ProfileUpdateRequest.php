<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
             'emergency_contact' => [
            'required',
            'string',
            'regex:/^[0-9]+$/', // This will ensure it's a number (you can modify this regex as needed)
            function ($attribute, $value, $fail) {
                // Normalize the number by stripping the country code.
                $normalizedNumber = $this->normalizePhoneNumber($value);

                // Check if the normalized number exists in the User table.
                $exists = DB::table('users')
                    ->whereRaw('REPLACE(phone, "+", "") = ?', [$normalizedNumber])
                    ->exists();

                if ($exists) {
                    $fail('The emergency contact number is already associated .');
                }
            }
        ],
        ];
    }
}
