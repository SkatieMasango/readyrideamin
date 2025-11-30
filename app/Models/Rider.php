<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Rider extends Model
{
    use HasFactory,SoftDeletes,HasRoles;
    protected $guarded = ['id'];
    protected $casts = [
    'current_location' => 'array',
];


    /**
     * Attributes
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function allowedCoupons()
    {
        return $this->belongsToMany(Coupon::class, 'rider_coupon', 'service_id', 'coupon_id');
    }
      public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // public function favouriteLocations(): HasMany
    // {
    //     return $this->hasMany(FavouriteLocation::class, 'rider_id');
    // }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'rider_id');
    }
      public function rating(): HasMany
    {
        return $this->hasMany(Rating::class, 'rider_id');
    }
}
