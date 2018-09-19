<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;

use App\Http\Controllers\ProductController;

class CategoryController extends Controller
{
    public function category_show(Request $request)
    {
        $categories = Category::all();
        $category = Category::find($request->id);
        foreach($category->products as $product){
            $product['tag_img_url'] = ProductController::get_tag_img($product);
        }
        $category['products'] = $category->products;
        $page = 'products';
        return view('home.categories.show', compact('category', 'page','categories'));
    }
}
