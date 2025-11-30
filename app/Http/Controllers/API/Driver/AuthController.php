<?php

namespace App\Http\Controllers\API\Driver;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\DriverService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentGatewayService;


class AuthController extends Controller
{
    protected $authService, $driverService, $paymentGatewayService;

    public function __construct(AuthService $authService, DriverService $driverService, PaymentGatewayService $paymentGatewayService)
    {
        $this->authService = $authService;
        $this->driverService = $driverService;
        $this->paymentGatewayService = $paymentGatewayService;
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required',
            'mobile' => 'required|string',
            'gender' => 'required|string',
        ]);

        $userId = Auth::user()->id;
        $user = UserRepository::findOrFail($userId);
        UserRepository::update($user, [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'gender' => $request->gender,
        ]);

        $driver = $user->driver;

        if(!$driver->stripe_customer && config('services.stripe.key') && config('services.stripe.public_key')) {
            PaymentGatewayService::makeCustomer(id:$user->id, name:$user->name, email:$user->email, role:'driver');
        }

        return $this->json('Contact info updated successfully', UserResource::make($user), 201);
    }
    public function destroy()
    {
        try {
            $user = Auth::user();
            // Soft delete the driver
            $user->driver?->delete();
            $user->driver?->user->delete();

            return $this->json(
                'Driver deleted successfully!',[],201
            );
        } catch (\Exception $e) {
            return $this->json(
                'Failed to delete driver',[],501
            );
        }
    }

    public function cardSave(Request $request)
    {
           $request->validate([
            'number' => 'required|string',
            'exp_month' => 'required|string',
            'exp_year' => 'required|string',
            'cvc' => 'required|string',
        ]);

        $customer = Auth::user()->driver;
        if($customer->stripe_customer === null){
            return $this->json('Please set your profile first',[], 422);
        }

        $card = $this->paymentGatewayService->cardSave($request,$customer->stripe_customer);
        return $this->json('Your card is added successfully', [
             'card' => $card
        ], 200);

    }

      public function myCards()
      {
        $customer = Auth::user()->driver;
         if($customer->stripe_customer === null){
            return $this->json('Please set your profile first',[], 422);
        }

        $card = $this->paymentGatewayService->getCardCustomerWise($customer->stripe_customer);

        return $this->json('Your card list', [
            'cards' => $card
        ], 200);
    }

     public function deleteCard($id){

        $customer = Auth::user()->driver;
        $this->paymentGatewayService->deleteSource($customer->stripe_customer, $id);
        return $this->json('Your card is deleted successfully', [], 200);

    }

    public function details()
    {
        $user = Auth::user();

        return $this->json('Driver Details fetch successfully',[
            'user' => UserResource::make($user),
        ], 200);
    }

    public function radiusUpdate(Request $request)
    {
        $request->validate([
            'radius_in_meter' => 'required',
        ]);

        $user = Auth::user();
        $driver = $user->driver;

        $driver->update([
            'radius_in_meter' => $request->radius_in_meter,
        ]);

        $user['radius_in_meter'] = $driver->radius_in_meter;
        $user['driver_status'] = $driver->driver_status;

        return $this->json('Driver available radius updated successfully', $user, 200);
    }
}
