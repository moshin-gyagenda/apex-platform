<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingInfo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'other_name',
        'email',
        'phone',
        'country',
        'state_region',
        'city',
        'street_address',
        'additional_info',
        'delivery_method',
        'status',
    ];

    /**
     * Get the user that owns the shipping info.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the orders for the shipping info.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
