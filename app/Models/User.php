<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'password',
        'profile_photo',
        'last_login_location',
        'last_login_latitude',
        'last_login_longitude',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Profile photo URL (from public/assets/images).
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo
            ? asset('assets/images/' . $this->profile_photo)
            : null;
    }

    /**
     * Alias for profile_photo (backend views use ->image).
     */
    public function getImageAttribute(): ?string
    {
        return $this->profile_photo;
    }

    /**
     * Alias for profile_photo_url (backend views use ->image_url).
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->getProfilePhotoUrlAttribute();
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the shipping info for the user.
     */
    public function shippingInfo()
    {
        return $this->hasOne(ShippingInfo::class)->latestOfMany();
    }

    /**
     * Get all shipping info records for the user.
     */
    public function shippingInfos()
    {
        return $this->hasMany(ShippingInfo::class);
    }

    /**
     * Get the reviews written by the user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the user's wishlist items.
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
