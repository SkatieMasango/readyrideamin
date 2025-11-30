<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SOSActivity extends Model
{
    /** @use HasFactory<\Database\Factories\SOSActivityFactory> */
    use HasFactory;
   protected $table = 'sos_activities';
    protected $fillable = [
        'status',
        'note',
        'operator_id',
        'sos_id',
    ];

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function sos()
    {
        return $this->belongsTo(SOS::class);
    }
}
