<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    /** @use HasFactory<\Database\Factories\FleetFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'account_number',
        'mobile_number',
        'commission_share_percent',
        'commission_share_flat',
        'address',
        'user_name',
        'password',
        'fee_multiplier',
        'exclusivity_areas',
    ];

    protected $casts = [
        'commission_share_percent' => 'integer',
        'commission_share_flat' => 'float',
        'fee_multiplier' => 'float',
        'exclusivity_areas' => 'array', // Cast exclusivity_areas as JSON
    ];

    /**
     * Relationships
     */

    // One-to-Many: Fleet can have multiple drivers
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
    public function operators()
    {
        return $this->hasMany(Operator::class);
    }

}
