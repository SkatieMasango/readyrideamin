<?php

namespace App\Http\Controllers\API\Driver;

use App\Enums\Status;
use Stripe\Stripe;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\DriverService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MediaRepository;
use App\Repositories\DriverRepository;
use App\Services\PaymentGatewayService;
use App\Http\Requests\PersonalInfoRequest;
use App\Http\Requests\ProfessionalInfoRequest;

class ProfileController extends Controller
{
    protected $authService;
    protected $driverService;

    public function __construct(AuthService $authService, DriverService $driverService)
    {
        $this->authService = $authService;
        $this->driverService = $driverService;
    }

    public function updatePersonalInfo(PersonalInfoRequest $request)
    {
        $userId = Auth::id();
        $user = UserRepository::find($userId);

        UserRepository::updateByRequest($request, $user);
        DriverRepository::update($user->driver, ['emergency_contact' => $request->emergency_contact]);
        MediaRepository::storeByRequest(
            $request->profile_picture,
            '/profile_image',
            'profile_picture',
            $user
        );

        if($user->driver->stripe_customer == null && config('services.stripe.key')){
            $secretKey  = config('services.stripe.key');
            $publishedKey = config('services.stripe.public_key');
            Stripe::setApiKey($secretKey);
            if ($secretKey && $publishedKey) {
                PaymentGatewayService::makeCustomer(id:$user->id,name:$user->name, email:$user->email, role:'driver');
            }
        }

        return $this->json('Contact info updated successfully', UserResource::make($user), 201);
    }

    /**
     * Handle professional info update
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfessionalInfo(ProfessionalInfoRequest $request)
    {

        $userId = Auth::user()->id;
        $user = UserRepository::find($userId);

        $this->driverService->uploadDocuments($request);

        DriverRepository::updateByRequest($request, $user->driver);

        return $this->json('Vehicle info updated successfully' , UserResource::make($user), 201);
    }

    public function statusUpdate(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Offline,Online',
        ]);
        $user = Auth::user();
        $userId = $user->id;

        if($user->status == Status::APPROVED){
            $driver = DriverRepository::query()->where('user_id', $userId)->first();

            $driver->update([
                'driver_status' => $request->status,
            ]);
            $driver->refresh();

            $user['radius_in_meter'] = $driver->radius_in_meter;
            $user['driver_status'] = $driver->driver_status;

            return $this->json('Driver status updated successfully', [
                'status' => $driver->driver_status
            ], statusCode:200);

        }elseif($user->status == Status::BLOCKED){
            return $this->json('You are blocked', statusCode:422);
        }else{
            return $this->json('You are not approved yet', statusCode:422);
        }


    }
}
