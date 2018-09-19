<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //

    protected $fillable =['name','img_url'];

    public function products(){
        return $this->hasMany('App\Product');
    }
}
