<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $fillable = [
        'product_id', 'quantity', 'user_id'
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
