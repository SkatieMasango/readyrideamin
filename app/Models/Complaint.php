<?php

namespace App\Models;

use App\Enums\ComplaintStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => ComplaintStatus::class,
    ];

    public function request()
    {
        return $this->belongsTo(Order::class,'request_id');
    }
     public function rider()
    {
        return $this->belongsTo(Rider::class,'rider_id');
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }
}
