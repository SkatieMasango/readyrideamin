<?php

namespace App\Models;

use App\Enums\PayoutType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payout extends Model
{
    protected $fillable = [
        'name',
        'description',
        'currency_name',
        'type',
        'payment_status',
        'image',
        'payout_gateway_id',
    ];

    protected $casts = [
        'type' => PayoutType::class,
    ];

    public function gateway()
    {
        return $this->belongsTo(PayoutGateway::class, 'payout_gateway_id');
    }

}
