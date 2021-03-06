<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function codes()
    {
        return $this->hasMany('App\Models\UserVerificationCode');
    }

    public function wishlist()
    {
        return $this->belongsToMany('App\Models\Product', 'wish_lists')->withTimestamps();
    }

    public function wishlistHas($productId)
    {
        return $this->wishlist()->where('product_id', $productId)->exists();
    }
}
