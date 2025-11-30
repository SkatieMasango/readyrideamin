<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutGateway extends Model
{
    protected $fillable = [
        'config',
        'mode',
        'alias'

    ];
    protected $casts = [
        'config' => 'array',
    ];


}
