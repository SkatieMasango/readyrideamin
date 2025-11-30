<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
      use HasFactory,SoftDeletes;

    protected $table = 'drivers';

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_id');
    }
    public function service()
{
    return $this->belongsTo(Service::class, 'service_id');
}

    public function vehicleColor()
    {
        return $this->belongsTo(VehicleColor::class, 'vehicle_color_id');
    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class, 'fleet_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

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
    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'driver_order')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class,'driver_id','id');
    }
     public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


}
