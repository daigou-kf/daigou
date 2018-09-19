<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;

class OrderController extends Controller
{
    /* update product sale after purchase */
    public static function update_sale($order_id)
    {
        $order = Order::find($order_id);
        foreach ($order->products as $product) {
            $sale_num = OrderProduct::where(['order_id' => $order_id,
                'product_id' => $product->id])->first()->quantity;
            $product->sale += $sale_num;
            $product->real_sale += $sale_num;
            $product->save();
        }
    }
}
