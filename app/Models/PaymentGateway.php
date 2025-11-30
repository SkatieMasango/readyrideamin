<?php

namespace App\Models;

use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PaymentGateway extends Model
{
    protected $guarded = [];

      protected $casts = [
        'type' => PaymentType::class,
    ];
 public function gatewayPicture(): MorphOne
{
    return $this->morphOne(Media::class, 'mediable');
}

    public function getGatewayPictureAttribute()
        {
            return optional($this->gatewayPicture()->first())->url ?? asset('/images/user.png');
        }

}
