<?php

namespace App\Services\Models;

use App\Models\Order;

class OrderService
{
    public static function initiateOrder($data)
    {
        return Order::create($data);
    }
}
