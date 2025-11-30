<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\PaymentType;
use App\Enums\PaymentStatus;

class Order extends Model
{

    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'expected_timestamp' => 'datetime',
        'driver_last_seen_messages_at' => 'datetime',
        'rider_last_seen_messages_at' => 'datetime',
        'start_timestamp' => 'datetime',
        'finish_timestamp' => 'datetime',
        'eta_pickup' => 'datetime',
        'points' => 'array',
        'addresses' => 'array',
        'directions' => 'array',
        'driver_directions' => 'array',
        'status' => OrderStatus::class,
        'payment_status' => 'boolean',
        // 'payment_status' => PaymentStatus::class,
        'payment_mode' => PaymentType::class
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
     public function ratings()
    {
        return $this->hasMany(Rating::class, 'order_id');
    }

    public function rider(): BelongsTo
    {
        return $this->belongsTo(Rider::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function serviceOptions(): BelongsToMany
    {
        return $this->belongsToMany(ServiceOption::class, 'order_service_option');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'driver_order')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function assignedDrievrs()
    {
        return $this->hasMany(DriverOrder::class, 'order_id');
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class);
    }

}
