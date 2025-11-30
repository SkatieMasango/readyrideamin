<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SOS extends Model
{
    /** @use HasFactory<\Database\Factories\SOSFactory> */
    use HasFactory;

    protected $table = 'sos';

    protected $fillable = [
        'status',
        'location',
        'request_id',
        'submitted_by_rider',
    ];

    protected $casts = [
        'location' => 'array',
    ];

       public function request()
       {
           return $this->belongsTo(Order::class,'request_id');
       }
       public function rider()
       {
           return $this->belongsTo(Rider::class,'submitted_by_rider');
       }
        public function driver()
       {
           return $this->belongsTo(Driver::class,'submitted_by_rider');
       }

    public function activities()
    {
        return $this->hasMany(SOSActivity::class);
    }
}
