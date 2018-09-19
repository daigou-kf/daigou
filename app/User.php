<?php

namespace App;

use App\Notifications\SendResetLink;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','password','phone','cuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function isAdmin(){
        if($this->admin == 1){
            return true;
        } else {
            return false;
        }
    }

    public function cart_products(){
        return $this->belongsToMany('App\Product','shopping_carts');
    }

    public function shopping_cart(){
        return $this->hasMany('App\ShoppingCart');
    }

    public function fav_products(){
        return $this->belongsToMany('App\Product','favourites');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function addresses(){
        return $this->hasMany('App\Address');
    }

    public function sender_addresses(){
        return $this->hasMany('App\SenderAddress');
    }

    public function services(){
        return $this->hasManyThrough('App\Service','App\Order');
    }

    public function settings(){
        return $this->hasOne('App\UserSettings');
    }

    public function routeNotificationForNexmo($notification){
        $phone_number = ltrim($this->phone, '0');
        $phone_number = '61'.$phone_number;
        Log::debug("number: ".$phone_number);
        return $phone_number;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SendResetLink($token));
    }

}
