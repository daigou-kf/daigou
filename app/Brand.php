<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable =['name','img_url'];

    protected $dates = ['deleted_at'];

    public function products(){
        return $this->hasMany('App\Product');
    }
}
