<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorRole extends Model
{
    /** @use HasFactory<\Database\Factories\OperatorRoleFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array', 
    ];
    public function operators()
    {
        return $this->hasMany(Operator::class, 'role_id');
    }
}
