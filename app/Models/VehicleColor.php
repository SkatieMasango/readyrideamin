<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleColor extends Model
{
    /** @use HasFactory<\Database\Factories\vehicleColorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Relationship: Drivers
     *
     * A vehicle color can have many drivers.
     */
    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class, 'vehicle_color_id');
    }
}
