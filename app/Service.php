<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function order(){
        return $this->belongsTo('App\Order');
    }
}
