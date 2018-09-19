<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Product;
use App\Category;
use App\Brand;
use App\Collection;

use App\Http\Controllers\ProductController;

class HomeController extends Controller
{
    public function home()
    {
        if(Session::has('welcome')){
            $welcome = true;
            Session::remove('welcome');
        }
        $page = "home";
        $products = Product::all()->take(50);
        foreach($products as $product){
            $product['tag_img_url'] = ProductController::get_tag_img($product);
        }
        $categories = Category::all();
        $collections = Collection::where('display',true)->get()->take(4);
        return view('home.home', compact('page', 'products','categories','collections','welcome'));
    }

    public function products()
    {
        $page = "products";
        $categories = Category::all();
        $type = 'category';
        return view('home.products', compact('page', 'categories', 'type'));
    }

    public function brands()
    {
        $page = "products";
        $brands = Brand::orderBy('order')->where('order','>','0')->get();
        $type = 'brand';
        return view('home.brands.index', compact('page', 'brands', 'type'));
    }

    public function gift_center()
    {
        $page = "gift_center";
        return view('home.gift_center', compact('page'));
    }

    public function shopping_cart()
    {
        $page = "shopping_cart";
        $rate = config('delivery.rate');
        return view('home.shopping_cart', compact('page','rate'));
    }

    public function dashboard()
    {
        $page = 'dashboard';
        return view('home.dashboard', compact('page'));
    }
}
