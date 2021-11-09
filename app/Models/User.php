<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function referred_through()
    {
        return $this->belongsTo('App\Models\User','referred_by','id');
    }

    public function referred_to()
    {
        return $this->hasMany('App\Models\User','referred_by','id');
    }

    public function user_points()
    {
        return $this->hasMany('App\Models\UserPoints','userId','id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\UserType','user_type','id');
    }

    public function purchase_subscription()
    {
        return $this->hasMany('App\Models\UserSubscription','userId','id');
    }

    public function product_purchase_lession()
    {
        return $this->hasMany('App\Models\UserProductLessionPurchase','userId','id')->latest();
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\UserRating','userId','id')->latest();
    }

    public function user_profile()
    {
        return $this->hasOne('App\Models\UserProfile','userId','id');
    }

    public function product_series()
    {
        return $this->hasMany('App\Models\ProductSeries','createdBy','id');
    }

    public function cart_info()
    {
        return $this->hasMany('App\Models\UserCart','userId','id')->where('status',1)->latest();
    }

    public function notification()
    {
        return $this->hasMany('App\Models\Notification','userId','id')->latest();
    }

    public function user_wish_list()
    {
        return $this->hasMany('App\Models\Wishlist','user_id','id')->with('wishlist_series')->latest();
    }
}
