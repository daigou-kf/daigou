<?php

namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;

class AdminController extends Controller
{
    public static function change_date($brand_array, $date){
        foreach ($brand_array as $brand_id){
            $brand = Brand::find($brand_id);
            foreach ($brand->products as $product){
                $product->expired_date = $date;
                $product->save();
            }
        }
    }
}
