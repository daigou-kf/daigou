<?php

use Illuminate\Http\Request;
use App\Category;
use App\Brand;
use App\Product;
use App\ShoppingCart;
use App\Order;
use App\OrderProduct;
use App\Address;
use App\Favourite;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// User Model
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Category Model
Route::get('categories',function(){
    $categories = Category::all();
   return response()->json($categories,200);
});

Route::get('categories/{id}',function($id){
    $category = Category::find($id);
    $products = $category->products;
    $category['products'] = $products;
    return response()->json($category ,200);
});


// Product Model
Route::get('products',function(){
    $products = Product::all();
    return response()->json($products,200);
});
Route::get('products/{id}',function($id){
   $product = Product::find($id);
   return response()->json($product,200);
});
Route::get('products/reward_points/{pospal_id}','ProductController@show_points');


// Address Model
Route::middleware('auth:api')->get('user/addresses',function(Request $request){
   $user = $request->user();
   $addresses = $user->addresses;
   return response()->json($addresses,200);
});

Route::middleware('auth:api')->post('user/add_address',function(Request $request){
    Address::create(['name' => $request->name,
        'detail' => $request->detail,
        'user_id' => Auth::user()->id]);
    return response()->json(['message' => '添加地址成功'] ,200);
});


// Order Model
Route::middleware('auth:api')->get('user/orders',function(Request $request){
    $user = $user = $request->user();
    $orders = $user->orders;
    return response()->json($orders,200);
});
Route::middleware('auth:api')->post('user/create_order',function(Request $request){
    $user = Auth::user();
    $shopping_cart = $user->shopping_cart;
    $total = 0;
    $quantity = 0;
    foreach ($shopping_cart as $product){
        $quantity += $product->quantity;
        $total += $product->quantity * Product::find($product->product_id)->price;
    }
    $order = new Order();
    $order->user_id = $user->id;
    $order->total = $total;
    $order->quantity = $quantity;
    $order->save();
    foreach ($shopping_cart as $product){
        OrderProduct::create(['order_id' => $order->id,
            'product_id' => $product->product_id,
            'quantity' => $product->quantity]);
    }
    ShoppingCart::where('user_id',$user->id)->delete();
    return response()->json(['message' => '已生成订单'],200);
});
Route::middleware('auth:api')->post('user/add_address_to_order',function(Request $request){
    $order = Order::where('user_id',Auth::user()->id)->find($request->order_id);
    $address = Address::where('user_id',Auth::user()->id)->find($request->address_id);
    $order->address_id = $address->id;
    $order->note = $request->note;
    $order->save();
    return response()->json(['message' => '添加订单收货地址信息成功'],200);
});


// Favourite Model
Route::middleware('auth:api')->get('user/likes', function(Request $request){
    $user = $user = $request->user();
    $fav_products = $user->fav_products;
    return response()->json($fav_products,200);
});
Route::middleware('auth:api')->post('user/add_to_likes', function(Request $request){
    Favourite::create(['product_id' => $request->product_id,
        'user_id' => Auth::user()->id]);
    return response()->json(['message' => '收藏成功'],200);
});


// Shopping Cart Model
Route::middleware('auth:api')->get('user/shopping_cart', function(Request $request){
    $user = $request->user();
    $shopping_cart = $user->shopping_cart;
    $shopping_cart['cart-products'] = $user->cart_products;
    return response()->json($shopping_cart,200);
});
Route::middleware('auth:api')->post('user/add_to_cart', function(Request $request){
    ShoppingCart::create(['product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'user_id' => Auth::user()->id]);
    return response()->json(['message' => '加入购物车成功'] ,200);
});




