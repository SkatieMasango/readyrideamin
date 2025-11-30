<?php

namespace App\Http\Controllers\API\Rider;

use Stripe\Stripe;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use App\Services\PaymentGatewayService;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $userId = Auth::user()->id;
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$userId,
            'gender' => 'required|string'
        ]);

        $user = UserRepository::find($userId);

        UserRepository::update($user, [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
        ]);

        $rider = $user->rider;

        $secretKey  = config('services.stripe.key');
        $publishedKey = config('services.stripe.public_key');
        if($rider->stripe_customer == null && $secretKey && $publishedKey) {
            Stripe::setApiKey($secretKey);
            if ($secretKey && $publishedKey) {
                PaymentGatewayService::makeCustomer(id:$user->id,name:$user->name, email:$user->email, role:'rider');
            }
        }

        return $this->json('Rider info updated successfully', [
            'user' => UserResource::make($user)
        ], 200);

    }

    public function show()
    {
        $userId = Auth::id();
        $user = UserRepository::find($userId);
        $rider = $user->rider;
        $orders = OrderRepository::query()->where('rider_id', $rider->id)
                   ->whereNot('status', OrderStatus::CANCELLED);

        $data['total_rides'] = $orders->count();
        $data['distance_travelled'] = (float) ($orders->sum('distance_best') * 1000);

        return $this->json('Rider info Fetch successfully', [
            'user' => UserResource::make($user),
            'total_rides' => $data['total_rides'],
            'distance_travelled' => $data['distance_travelled']
        ], 200);
    }
}
