<?php

namespace App\Http\Controllers\API\Driver;

use App\Models\Driver;
use App\Enums\OrderStatus;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\AssignDriverTrait;
use App\Http\Resources\Rider\OrderResource;
use App\Repositories\DriverRepository;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    use AssignDriverTrait;

    public function index(): JsonResponse
    {
        $orders = OrderRepository::searchOrders();

        if ($orders->isEmpty()) {
            return $this->json(message: 'No Order Available');
        }

        return $this->json('All Orders', [
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function show(int $orderId): JsonResponse
    {
        $order = OrderRepository::findOrFail($orderId);

        return $this->json(message: 'Order Found', data: new OrderResource($order));
    }

    public function onTrip(): JsonResponse
    {
        $driver = Driver::where('user_id', Auth::id())->first();

        $order = $driver->orders()->whereNotIn('status', [OrderStatus::PENDING,OrderStatus::CANCELLED, OrderStatus::COMPLETED])->latest()->first();

        if (!$order) {
            return $this->json('No active trip found',[
                'order' => null
            ], statusCode: 200);
        }

        return $this->json('Successfully retrieve active trip',[
            'order' => OrderResource::make($order)
        ]);
    }
}

