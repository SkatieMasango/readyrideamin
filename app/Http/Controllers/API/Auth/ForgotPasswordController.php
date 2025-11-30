<?php

namespace App\Http\Controllers\API\Auth;

use BcMath\Number;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\NumberVerifyRequest;

class ForgotPasswordController extends Controller
{
    /**
     * Sends an OTP to the given mobile number.
     *
     * First normalizes the mobile number, then checks if a user with that
     * mobile number exists. If the user exists, generates a new OTP and stores
     * it in cache, then sends a JSON response with the mobile number and the
     * OTP. If the user does not exist, returns an error response.
     *
     * @param NumberVerifyRequest $request HTTP request containing 'mobile' and 'country_code' fields.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     */
    public function requestOtp(NumberVerifyRequest $request)
    {
        $mobile = $this->normalizePhoneNumber($request->mobile, $request->country_code);
        $user = UserRepository::query()->withTrashed()->where('mobile', $mobile)->first();
        if (!$user) {
            return $this->json('User not found', 401);
        }

        $otp = $this->setOTP($mobile);

        return $this->json('OTP sent successfully.', [
            'mobile' => $mobile,
            'otp' => app()->environment('local') ? $otp : null
        ], statusCode:200);
    }

/**
 * Verifies the OTP for a given mobile number.
 *
 * Validates the OTP provided by the user against the stored OTP in cache.
 * If the OTP is valid, generates a password reset token and stores it
 * in the password_resets table.
 *
 * @param Request $request HTTP request containing 'mobile' and 'otp' fields.
 * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
 */

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric',
            'otp' => 'required|numeric',
        ]);

        $storedOtp = Cache::get("otp_{$request->mobile}");

        if (!$storedOtp || $storedOtp != $request->otp) {
            return $this->json('Invalid OTP.', 422);
        }
        // Clear the OTP from cache after successful verification
        $token = Str::random(32);
        DB::table('password_resets')->updateOrInsert(
            ['mobile' => $request->mobile],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        return $this->json('Password reset token generated successfully!', ['token' => $token]);

    }

    /**
     * Resets the password for a user with a given mobile number and token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);

        $user = UserRepository::query()->withTrashed()->where('mobile', $request->mobile)->first();
        if (! $user) {
            return $this->json('User not found', 401);
        }

        $reset = DB::table('password_resets')
            ->where('mobile', $request->mobile)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return $this->json('Invalid token', 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return $this->json(message: 'Password reset successful!');
    }

}
