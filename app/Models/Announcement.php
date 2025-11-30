<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'body',
        'type',
        'user_ids',
    ];

    protected $casts = [
        'user_ids' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_ids');
    }
}
