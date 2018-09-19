<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Collection;

use App\Http\Controllers\ProductController;

class CollectionController extends Controller
{
    public function collection_show($id){
        $collection = Collection::find($id);
        $products = $collection->products;
        foreach($products as $product){
            $product['tag_img_url'] = ProductController::get_tag_img($product);
        }
        $page = 'products';
        return view('home.collections.show',compact('collection','products','page'));
    }
}
