<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'max_users', // 0 means unlimited users can use it
        'max_uses_per_user', // 1 means each user can use it once
        'minimum_cost',
        'maximum_cost',
        'valid_from',
        'start_time',
        'valid_till',
        'expired_time',
        'discount_percent',
        'discount_flat',
        'rider_ids',
        'is_enabled',
        'is_notified',
        'is_first_travel_only',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_till' => 'datetime',
        'is_enabled' => 'boolean',
        'is_first_travel_only' => 'boolean',
        'rider_ids' => 'array',
    ];


    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'coupon_service');
    }

    public function riders(): BelongsToMany
    {
        return $this->belongsToMany(Rider::class, 'coupon_rider');
    }
    public function riderIds()
    {
        return $this->hasMany(Rider::class, 'id');
    }
}
