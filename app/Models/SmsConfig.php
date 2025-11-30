<?php

namespace App\Models;

use App\Enums\SmsType;
use Illuminate\Database\Eloquent\Model;

class SmsConfig extends Model
{
   protected $guarded = [];

      protected $casts = [
        'type' => SmsType::class,
    ];
}
