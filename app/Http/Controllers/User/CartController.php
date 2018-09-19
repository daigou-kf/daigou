<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\PospalController;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\ShoppingCart;
use App\OrderProduct;
use App\Order;

use App\Jobs\OrderExpire;

class CartController extends Controller
{
    public function __construct()
    {
        if (!session()->has('cart')) {
            session()->put('cart', array());
        }
    }

    public function get_cart_products()
    {
        $cart = session()->get('cart');
        if (count($cart) != 0) {
            $products = Product::whereIn('id', array_keys($cart))->get();
            foreach ($products as $product) {
                $product['quantity'] = $cart[$product->id];
            }
            return response()->json($products, 200);
        } else {
            return response()->json(array(), 200);
        }
    }

    public function add_to_cart(Request $request)
    {

        /* validate request */
        if (!isset($request->product_id) || !isset($request->quantity)) {
            return response()->json(['message' => 'error', 'data' => 'format incorrect'], 403);
        }
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        if ($quantity <= 0) {
            return response()->json(['message' => 'error', 'data' => 'invalid quantity'], 403);
        }
        try {
            Product::findOrFail($product_id);
        } catch (\Exception $e) {
            Log::debug($e);
            return response()->json(['message' => 'error', 'data' => 'product not found'], 403);
        }

        /* update cart */
        $cart = session()->pull('cart');
        if (array_key_exists($product_id, $cart)) {
            $cart[$product_id] += $quantity;
            session()->put('cart', $cart);
        } else {
            $cart[$product_id] = $quantity;
            session()->put('cart', $cart);
        }
        return response()->json('success', 200);
    }

    public function update_cart(Request $request)
    {
        /* validate request */
        if (!isset($request->product_id) || !isset($request->quantity)) {
            return response()->json(['message' => 'error', 'data' => 'format incorrect'], 403);
        }

        /* validate request data */
        $product_id = $request->get('product_id');
        $quantity = $request->get('quantity');
        if ($quantity <= 0) {
            return response()->json(['message' => 'fail'], 403);
        }
        $cart = session()->get('cart');
        if (array_key_exists($product_id, $cart)) {
            $cart[$product_id] = $quantity;
            session()->put('cart', $cart);
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'fail'], 403);
        }
    }

    public function remove_from_cart(Request $request)
    {
        /* validate request */
        if (!$request->has('product_id')) {
            return response()->json('error', 403);
        }

        $product_id = $request->product_id;
        try {
            Product::findOrFail($product_id);
        } catch (\Exception $e) {
            Log::debug($e);
            return response()->json(['message' => 'error', 'data' => 'product not found'], 403);
        }

        $cart = session()->pull('cart');
        if (array_key_exists($product_id, $cart)) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
            return response()->json(['message' => 'success'], 200);
        } else {
            Log::debug("********** MALICIOUS USER INPUT **********");
            Log::debug("Someone tried to delete a cart item that didn't exist");
            session()->put('cart', $cart);
            return response()->json(['message' => 'error', 'data' => 'item not in cart'], 403);
        }

    }

    public function clear_cart()
    {
        session()->pull('cart');
        return response()->json('success', 200);
    }

    public function select_package_method()
    {
        $page = 'shopping_cart';
        return view('home.orders.select_package_method', compact('page'));
    }

    public function create_order(Request $request)
    {
        if(!$request->has('package_method')){
            return redirect(route('home_select_package_method'));
        }
        try {
            $package_method = $request->get('package_method');
            if($package_method != 'auto' && $package_method != 'self'){
                return redirect(route('home_select_package_method'));
            }
            $user = Auth::user();
            $cart = session()->get('cart');
            if (count($cart) == 0) {
                return redirect(route('home_cart'))->with('fail','创建订单出错');
            }
            if ($this->check_stock($cart) == false) {
                return redirect(route('home_cart'))->with('fail','创建订单出错');
            }
            $cart = session()->pull('cart');
            $order = new Order();
            $order->user_id = $user->id;
            $order->package_method = $package_method;
            $order->save();
            $cart_products = Product::whereIn('id', array_keys($cart))->get();
            $total = 0;
            $quantity = 0;
            $weight = 0;
            foreach ($cart_products as $cart_product) {
                $total += $cart_product->price * $cart[$cart_product->id];
                $quantity += $cart[$cart_product->id];
                $weight += $cart_product->weight * $cart[$cart_product->id];
                OrderProduct::create(['product_id' => $cart_product->id,
                    'order_id' => $order->id,
                    'quantity' => $cart[$cart_product->id]]);
            }
            if ($weight < 1000) {
                $weight = 1000;
            }
            $order->total = number_format($total + $weight * config('delivery.rate'), 2, '.', '');
            $order->quantity = $quantity;
            $order->weight = $weight;
            $order->save();
            if($order->package_method == 'auto'){
                OrderExpire::dispatch($order)->delay(now()->addMinutes(35));
            }
            return redirect(route('home_order_show',['id'=>$order->id]));
        } catch (\Exception $e) {
            Log::debug($e);
            return redirect(route('home_cart'))->with('fail','创建订单出错');
        }
    }

    /**
     * Determine if stock is available for cart items
     * @param $cart
     * @return true if there is enough stocks, false for not enough stocks
     */
    public function check_stock($cart)
    {
        try {
            foreach (array_keys($cart) as $product_id) {
                $stock = PospalController::find_product_by_barcode(Product::find($product_id)->pospal_id)['stock'];
                if ($cart[$product_id] > $stock) {
                    return false;
                }
            }
            return true;
        } catch (\Exception $e) {
            Log::debug($e);
            return false;
        }
    }
}
