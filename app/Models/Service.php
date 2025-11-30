<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'time_multipliers' => 'array',
        'distance_multipliers' => 'array',
        'date_range_multipliers' => 'array',
        'weekday_multipliers' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function serviceLogo(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'service_logo');
    }

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function allowedCoupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'service_coupon', 'service_id', 'coupon_id');
    }

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class);
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(ServiceOption::class);
    }
    public function media()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

     public function servicePicture(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'service_picture');
    }

    public function getservicePictureAttribute()
    {
        return optional($this->servicePicture()->first())->url ?? asset('images/dummies/economy.png');
    }

    // public function logoPath(): Attribute
    // {
    //     return new Attribute(
    //         get: fn () => $this->serviceLogo ? $this->serviceLogo->path : asset('images/dummies/economy.png'),
    //     );
    // }
}
