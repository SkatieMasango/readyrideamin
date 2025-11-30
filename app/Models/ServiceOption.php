<?php

namespace App\Models;

use App\Enums\ServiceOptionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ServiceOption extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceOptionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'additional_fee',
    ];

    protected $casts = [
        'additional_fee' => 'float',
        'type' => ServiceOptionType::class,
    ];

    public function optionIcon(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'option_icon');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_option_service');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_service_option');
    }
}
