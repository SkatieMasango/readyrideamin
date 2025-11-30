<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

abstract class Controller
{
    /**
     * Create a new JSON response instance.
     *
     * @param  string  $message
     * @param  mixed  $data
     * @param  int  $statusCode
     * @param  array  $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json(?string $message = null, $data = [], $statusCode = 200, array $headers = [])
    {
        $content = [];
        if ($message) {
            $content['message'] = $message;
        }

        if (! empty($data)) {
            $content['data'] = $data;
        }

        return response()->json($content, $statusCode, $headers, JSON_PRESERVE_ZERO_FRACTION);
    }

        /**
     * Set OTP for the given mobile number, if otp is not given, generate a new one.
     *
     * @param string $mobile
     * @param int|null $otp
     * @return int
     */
    protected function setOTP($mobile): int
    {
        $otp = rand(100000, 999999);
        Cache::put("otp_{$mobile}", $otp, 300);
        return $otp;
    }


    /**
     * Normalize a phone number by removing non-digit characters,
     * leading zeros, and duplicated country code, then prepend the country code.
     *
     * @param string $phoneNumber The phone number to be normalized.
     * @param string $countryCode The country code to be prepended to the normalized phone number.
     * @return string The normalized phone number with the country code.
     */
    protected function normalizePhoneNumber($phoneNumber, $countryCode)
    {
        $numericCountryCode = ltrim($countryCode, '+');

        // Remove all non-digits
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Remove leading 0s or duplicated country code
        $phoneNumber = preg_replace('/^0+/', '', $phoneNumber);
        $phoneNumber = preg_replace("/^{$numericCountryCode}/", '', $phoneNumber);

        // Append cleaned number to country code
        return $countryCode . $phoneNumber;
    }
}
