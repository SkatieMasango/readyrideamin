<?php

namespace App\Http\Controllers\API\Rider;


use App\Http\Controllers\Controller;
use App\Http\Resources\Rider\RatingResource;
use App\Models\Rider;
use App\Models\Order;
use App\Models\Wallet;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Driver;
use App\Models\Rating;
use App\Repositories\UserRepository;
use App\Services\PaymentGatewayService;

class AuthController extends Controller
{

    protected $authService, $paymentGatewayService;

    public function __construct(AuthService $authService, PaymentGatewayService $paymentGatewayService)
    {
        $this->authService = $authService;
        $this->paymentGatewayService = $paymentGatewayService;
    }

    public function destroy()
    {
        $user = UserRepository::find(Auth::id());
        $user->rider?->delete();
        $user?->delete();

        return $this->json('Rider deleted successfully!');
    }

    public function createRating(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:255',
            'order_id' => 'required|exists:orders,id'
        ]);
        $user   = Auth::user();
        $order = Order::where('id', $request->order_id)->first();
        $driver = Driver::where('id', $order->driver_id)->first();
        $rider = Rider::where('user_id', $user->id)->first();
        $data = Rating::create([
            'rating' => $request->rating,
            'driver_id' => $driver->id,
            'rider_id' => $rider->id,
            'order_id' => $order->id,
            'comment' => $request->comment
        ]);

        $totalRating = Rating::where('driver_id', $driver->id)->sum('rating');
        $ratingCount = Rating::where('driver_id', $driver->id)->count();

        $averageRating = $ratingCount > 0 ? round($totalRating / $ratingCount, 2) : 0;

        $driver->update([
            'rating' => $averageRating
        ]);

        return $this->json('Rating is created successfully.' ,[
            'rating' => RatingResource::make($data)
        ], 201);
    }

    public function wallet()
    {
        $user = Auth::user();
        $userId = $user->id;
        $rider = Rider::where('user_id', $userId)->first();
        $wallet = Wallet::where('user_id', $rider->user_id)->first();

        return $this->json('Wallet fetched successfully', [
            'balance' => (float) number_format($wallet?->amount ?? 0, 2)
        ], 200);
    }

    public function addCard(Request $request)
    {
        $request->validate([
            'number' => 'required|string',
            'exp_month' => 'required|string',
            'exp_year' => 'required|string',
            'cvc' => 'required|string',
        ]);
        $user = Auth::user();
        $customer = $user->rider;

        if($customer->stripe_customer === null){
            return $this->json('Please set your profile first',[], 422);
        }

        $card = $this->paymentGatewayService->cardSave($request,$customer->stripe_customer);
        return $this->json('Your card is added successfully', [
            'card' => array_merge($card->toArray(), ['name' => 'Stripe'])
        ], 200);
    }

    public function myCards()
    {
        $customer = Auth::user()->rider;
         if($customer->stripe_customer === null){
            return $this->json('Please set your profile first',[], 422);
        }

        $card =$this->paymentGatewayService->getCardCustomerWise($customer->stripe_customer);

        return $this->json('Your card list', [
            'cards' => $card
        ], 200);
    }

     public function deleteCard($id)
     {
        $customer = Auth::user()->rider;
        $this->paymentGatewayService->deleteSource($customer->stripe_customer, $id);
        return $this->json('Your card is deleted successfully', [], 200);
    }

    public function addBalance(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $userId = $user->id;
        $rider = Rider::where('user_id', $userId)->first();
        $wallet = Wallet::where('user_id', $rider->user_id)->first();

        $wallet->amount = $wallet->amount + $request->amount;
        $wallet->update();

        return $this->json('Added balance successfully',[
            'balance' => (float) number_format($wallet?->amount ?? 0, 2)
        ]);
    }
}
