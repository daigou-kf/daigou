<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\Brand;
use App\Category;
use App\Favourite;

class ProductController extends Controller
{
    public function product_show(Request $request)
    {
        $user = Auth::user();
        $page = "products";
        $product = Product::find($request->id);
        $product['brand'] = Brand::find($product->brand_id);
        $product['category'] = Category::find($product->category_id);
        if($user == null){
            $product['like'] = 0;
        } else {
            $like = Favourite::where('user_id', $user->id)->where('product_id', $request->id)->first();
            if ($like) {
                $product['like'] = 1;
            } else {
                $product['like'] = 0;
            }
        }

        return view('home.products.show', compact('product', 'page'));
    }

    public function get_product(Request $request)
    {
        $user = Auth::user();
        $product = Product::find($request->id);
        $product['brand'] = Brand::find($product->brand_id);
        $product['category'] = Category::find($product->category_id);
        $like = Favourite::where('user_id', $user->id)->where('product_id', $request->id)->first();
        if ($like) {
            $product['like'] = 1;
        } else {
            $product['like'] = 0;
        }
        return response()->json($product, 200);
    }

    public function update_like(Request $request)
    {
        $user = Auth::user();
        $favourite = Favourite::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
        if ($favourite) {
            $favourite->delete();
            return response()->json('已取消收藏', 200);
        } else {
            Favourite::create(['user_id' => $user->id,
                'product_id' => $request->product_id]);
            return response()->json('收藏成功', 200);
        }
    }

    public function product_detail(Request $request)
    {
        $page = 'products';
        $product = Product::find($request->id);
        return view('home.products.detail', compact('page', 'product'));
    }

    public function search_products(Request $request)
    {
        $page = 'products';
        $search_query = $request->search_query;
        if ($search_query == 'price_up') {
            $products = Product::orderBy('price')->get();
        } elseif ($search_query == 'price_down') {
            $products = Product::orderBy('price', 'desc')->get();
        } elseif ($search_query == 'sale_down') {
            $products = Product::orderBy('sale', 'desc')->get();
        } else {
            $products = Product::search($search_query)->get();
        }
        return view('home.searches.show', compact('products', 'page', 'search_query'));
    }

    public function favourite_index()
    {
        $page = 'dashboard';
        return view('home.favourites.index', compact('page'));
    }

    public function get_fav()
    {
        $user = Auth::user();
        $fav_products = $user->fav_products;
        return response()->json($fav_products, 200);
    }
}
