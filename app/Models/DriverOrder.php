<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverOrder extends Model
{
    protected $table = 'driver_orders';
    
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
