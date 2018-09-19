<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'total', 'quantity'
    ];

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'order_products')->withTrashed();
    }

    public function address()
    {
        return $this->belongsTo('App\Address')->withTrashed();
    }

    public function sender_address()
    {
        return $this->belongsTo('App\SenderAddress')->withTrashed();
    }

    public function service()
    {
        return $this->hasOne('App\Service');
    }






}
