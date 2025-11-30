<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleModel extends Model
{

    use HasFactory;

     protected $fillable = [
        'name',
        'vehicle_brand_id'
    ];

    public function brand(): BelongsTo
{
    return $this->belongsTo(VehicleBrand::class,'vehicle_brand_id');
}

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class, 'vehicle_id');
    }
}
