<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasRoles;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    protected $appends = ['profile_picture'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => Status::class,
        ];
    }

    protected function emailVerifiedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    protected function otpVerifiedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions','role_id');
    }

    public function profilePicture(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'profile_picture');
    }

    public function getProfilePictureAttribute()
    {
        return optional($this->profilePicture()->first())->url ?? asset('assets/images/user.png');
    }

    public function nidPicture(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'nid');
    }

    public function getNidPictureAttribute()
    {
        return optional($this->nidPicture()->first())->url ?? asset('assets/images/documents.png');
    }
    public function licensePicture(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'license');
    }

    public function getLicensePictureAttribute()
    {
        return optional($this->licensePicture()->first())->url ?? asset('assets/images/documents.png');
    }
        public function ownershipPicture(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'vehicle_paper');
    }

    public function getOwnershipPictureAttribute()
    {
        return optional($this->ownershipPicture()->first())->url ?? asset('assets/images/documents.png');
    }

    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }

    public function rider(): HasOne
    {
        return $this->hasOne(Rider::class);
    }

    public function documents()
    {
        return $this->morphMany(Media::class, 'mediable');
    }


    public function isNew(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->driver && (!$this->nidPicture()->first() || !$this->driver->emergency_contact)) {
                    return true;
                }
                // return $this->otp_verified_at ? false : true;
            }
        );
    }
    public function wallet()
    {
        return $this->hasMany(Wallet::class);

    }

}
