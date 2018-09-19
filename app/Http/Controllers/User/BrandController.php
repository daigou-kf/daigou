<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Brand;

use App\Http\Controllers\ProductController;

class BrandController extends Controller
{
    public function brand_show(Request $request)
    {
        $brand = Brand::find($request->id);
        foreach($brand->products as $product){
            $product['tag_img_url'] = ProductController::get_tag_img($product);
        }
        $brand['products'] = $brand->products;
        $page = 'products';
        return view('home.brands.show', compact('brand', 'page'));
    }

    public function get_other_brands()
    {
        $brands = Brand::all()->where('order', '==', null)->sortBy('id');
        return response()->json($brands, 200);
    }
}
