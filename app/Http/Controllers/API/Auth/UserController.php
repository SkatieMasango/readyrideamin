<?php

namespace App\Http\Controllers\API\Auth;

use App\Enums\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\NumberVerifyRequest;
use App\Http\Resources\UserResource;
use App\Repositories\MediaRepository;

class UserController extends Controller
{

    /**
     * Handle a signin request for the given role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(NumberVerifyRequest $request, $role)
    {
        $mobile = $this->normalizePhoneNumber($request->mobile, $request->country_code);
        $user = UserRepository::findOrStoreByMobile($mobile, $request);

        $mobile = $user->mobile;

        if(request()->query('is_login') == 'yes'){
            $user->tokens()->delete();

            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $user->update([
                'device_token' => $request->device_token,
            ]);

            return $this->json('Login successful.', [
                'user' => new UserResource($user),
                'token' => $token,
            ]);
        }


        if (!$request->password && !$request->otp) {
            $otp = $this->setOTP($mobile);
            if($role == 'rider'){
                $riderRole = $user->otp_verified_at ? false : true;
            }

            $data = [
                'mobile' =>  $mobile,
                'otp' => app()->environment('local') ? $otp : null,
                'is_new_' . $role => $role == 'driver' ? $user->isNew : $riderRole,
            ];
            if($user->driver || $role == 'driver'){
                $data['is_under_review'] = (!$user->isNew && $user->status == Status::PENDING_APPROVAL) ? true : false;
            }

            return $this->json('The OTP has been sent successfully.', $data , 201);
        }

        if ($request->has('password')) {
            if(!Hash::check($request->password, $user->password) ) {
                return $this->json('Invalid credentials.', statusCode: 422);
            }
        } elseif ($request->has('otp')) {
            $storedOtp = Cache::get("otp_{$mobile}");
            if (!$storedOtp || $storedOtp != $request->otp) {
                return $this->json('Invalid OTP.', statusCode: 422);
            }
            $user->update(['otp_verified_at' => now()]);
        } else {
            return $this->json('Password or OTP is required.', statusCode: 422);
        }

        $token = $user->createToken('Personal Access Token')->plainTextToken;
        Cache::forget("otp_{$mobile}");

        if($user->device_token && $user->device_token != $request->device_token){
            return $this->json('You are already logged in another device.', [
            'user' => UserResource::make($user),
            'other_device' => true,
        ], 200);

        }

        $user['device_token'] = $request->device_token ?? null;
        $user->update();

        return $this->json('Login successful.', [
            'user' => UserResource::make($user),
            'token' => $token,
        ], 200);
    }




    /**
     * Resend OTP for the given mobile number.
     *
     * @param SigninRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendOTP(Request $request)
    {
        $request->validate([
            'mobile' => 'required|exists:users,mobile',
        ]);
        $user = UserRepository::query()->withTrashed()->where('mobile', $request->mobile)->first();

        if (!$user) {
            return $this->json('User not found.', 404);
        }

        $otp = $this->setOTP($request->mobile);

        return $this->json('OTP resent successfully.',[
            'mobile' => $request->mobile,
            'otp' => app()->environment('local') ? $otp : null
        ], 200);
    }

    public function setupPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);
        $user = UserRepository::findOrFail(Auth::user()->id);

        if (!$user) {
            return $this->json('Unauthorized', 401);
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return $this->json('Password updated successfully.', statusCode:200);
    }

    /**
     * Log out the authenticated user by revoking their access tokens.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $request->user()->update(['device_token' => null]);
        $request->user()->driver()->update(['driver_status' => 'Offline']);
        return $this->json('Sign-out successful.');
    }

    /**
     * Update the user's profile picture.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfilePicture(Request $request, $role)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $user = UserRepository::findOrFail(Auth::user()->id);

        MediaRepository::storeByRequest($request->profile_picture,  $role . '/profile_image', 'profile_picture', $user);

        return $this->json('Profile picture updated successfully.', [
            'user' => UserResource::make($user),
        ], 200);
    }

/**
 * Change the user's password after validating the current password.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 *
 * Validates the request to ensure that the current password, new password,
 * and password confirmation are provided. Checks if the current password
 * is correct for the authenticated user. If so, updates the user's password
 * with the new one. Returns a JSON response indicating success or an error
 * if the current password is incorrect.
 */

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        $user = UserRepository::find(Auth::id());
        if (!$user || !password_verify($request->current_password, $user->password)) {
            return $this->json('Current password is incorrect.', statusCode:422);
        }

        $user->update(['password' => bcrypt($request->password)]);

        return $this->json('Password changed successfully.', [], 201);
    }
}
