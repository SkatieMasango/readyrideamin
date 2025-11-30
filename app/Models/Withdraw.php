<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Withdraw extends Model
{
    protected $guarded = [];
    public function driver(): HasOne
        {
            return $this->hasOne(Driver::class,'id','driver_id');
        }
}
