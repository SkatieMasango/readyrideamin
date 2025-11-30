<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'name',
        'path',
        'type',
        'mime_type',
        'file_size',
        'mediable_type',
        'mediable_id',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }

    // Get full image URL
    public function getUrlAttribute()
    {
        return $this->path ? asset("storage/{$this->path}") : asset('/images/user.png');
    }

      protected static function boot()
    {
        parent::boot();
        static::deleting(function ($media) {
            Storage::disk('public')->delete($media->path);
        });
    }


}
