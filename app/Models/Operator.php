<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
{
    /** @use HasFactory<\Database\Factories\OperatorFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'operators';

    protected $fillable = [
        'name',
        'user_name',
        'password',
        'mobile_number',
        'enabled_notifications',
        'email',
        'address',
        'media_id',
        'role_id',
        'fleet_id',
    ];

    protected $casts = [
        'enabled_notifications' => 'array',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function role()
    {
        return $this->belongsTo(OperatorRole::class, 'role_id');
    }

}
