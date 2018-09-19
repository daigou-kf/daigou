<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function select_package_method(){
        $page = 'shopping_cart';
        return view('home.orders.select_package_method',compact('page'));
    }

    public function order_index()
    {
        $page = 'dashboard';
        return view('home.orders.index', compact('page'));
    }

    public function all_orders()
    {
        $user = Auth::user();
        $orders = $user->orders;
        foreach ($orders as $order) {
            $order['sending_address'] = $order->address;
            $order['sender_address'] = $order->sender_address;
            $products = $order->products;
            foreach ($products as $product) {
                $product['num'] = $product->get_order_quantity($order->id);
            }
            $order['products'] = $order->products;
        }
        return response()->json($orders, 200);
    }

    public function order_show(Request $request)
    {
        $page = 'dashboard';
        $user = Auth::user();
        $order = $user->orders->find($request->id);
        $products = $order->products;
        foreach ($products as $product) {
            $product['num'] = $product->get_order_quantity($order->id);
        }
        $order['products'] = $products;
        $order->address ? $order['sending_address'] = $order->address : $order['sending_address'] = null;
        $order->sender_address ? $order['sender_address'] = $order->sender_address : $order['sender_address'] = null;
        $sending_addresses = $user->addresses;
        $sender_addresses = $user->sender_addresses;
        $order['sending_addresses'] = $sending_addresses;
        $order['sender_addresses'] = $sender_addresses;
        $order['images'] = explode('|',$order->images);
        $order['deli_images'] = explode('|',$order->deli_images);
        $order->weight > 1000 ? $order['weight_fee'] = $order->weight * config('delivery.rate') : $order['weight_fee'] = 1000 * config('delivery.rate');
        $order['delivery_no'] = explode("|",$order->delivery_no);
        $user_credits = $user->balance;
        $user_setting = $user->settings;
        if($user_setting->show_delivery_reminder){
            $reminder = true;
        }

        return view('home.orders.show', compact('page', 'order','user_credits','reminder'));
    }

    public function unpaid_orders()
    {
        $user = Auth::user();
        $orders = $user->orders->where('status', 0);
        foreach ($orders as $order) {
            $order['sending_address'] = $order->address;
            $order['sender_address'] = $order->sender_address;
            $products = $order->products;
            foreach ($products as $product) {
                $product['num'] = $product->get_order_quantity($order->id);
            }
            $order['products'] = $order->products;
        }
        return response()->json($orders, 200);
    }

    public function paid_orders()
    {
        $user = Auth::user();
        $orders = $user->orders->where('status', 1);
        foreach ($orders as $order) {
            $order['sending_address'] = $order->address;
            $order['sender_address'] = $order->sender_address;
            $products = $order->products;
            foreach ($products as $product) {
                $product['num'] = $product->get_order_quantity($order->id);
            }
            $order['products'] = $order->products;
        }
        return response()->json($orders, 200);
    }

    public function sending_orders()
    {
        $user = Auth::user();
        $orders = $user->orders->where('status', 2);
        foreach ($orders as $order) {
            $order['sending_address'] = $order->address;
            $order['sender_address'] = $order->sender_address;
            $products = $order->products;
            foreach ($products as $product) {
                $product['num'] = $product->get_order_quantity($order->id);
            }
            $order['products'] = $order->products;
        }
        return response()->json($orders, 200);
    }

    public function completed_orders()
    {
        $user = Auth::user();
        $orders = $user->orders->where('status', 3);
        foreach ($orders as $order) {
            $order['sending_address'] = $order->address;
            $order['sender_address'] = $order->sender_address;
            $products = $order->products;
            foreach ($products as $product) {
                $product['num'] = $product->get_order_quantity($order->id);
            }
            $order['products'] = $order->products;
        }
        return response()->json($orders, 200);
    }

    public function confirm_order(Request $request)
    {
        $user = Auth::user();
        $order = $user->orders->find($request->order_id);
        if ($order->status == 2) {
            $order->status = 3;
            $order->save();
        }
    }

    public function create_payment(Request $request)
    {
        $user = Auth::user();
        $order = $user->orders->find($request->order_id);
        if ($order->status == 0 && $order->payment_link) {
            return redirect($order->payment_link);
        } else {
            if ($order->status != 0) {
                return redirect(route('index'));
            } elseif (!isset($request->address_id) || !isset($request->sender_address_id)) {
                return redirect(route('index'));
            } else {
                $order->address_id = $request->address_id;
                $order->sender_address_id = $request->sender_address_id;
                if ($request->addon == 'on') {
                    $order->addon = 1;
                    $order->total += 1;
                }
                $order->credits = $request->credits;
                $order->note = $request->note;
                return $this->create_transaction($order);
            }
        }
    }

    public function track_delivery($delivery_no)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.transrush.com.au/track/search.json?number=".$delivery_no,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json('error',403);
        } else {
            $response = json_decode($response);
            return response()->json($response->data,200);
        }
    }

    public function create_transaction($order)
    {
        $user = Auth::user();
        $user_id = $user->id;
        if($order->credits > $user->balance || $order->credits > $order->total){
            return redirect(route('home_order_show',['id'=>$order->id]))->with('fail','余额使用错误');
        }
        if($order->credits == $order->total){
            $user->balance -= $order->credits;
            $order->status = 1;
            $order->payment_link = "by credits";
            $order->save();
            $user->save();
            PospalController::change_multiple_inventory($order->id);
            OrderController::update_sale($order->id);
            UserController::add_points($user->id,$order->id);
            return redirect(route('home_order_index'))->with('success','支付成功');
        }
        $trade_id = sprintf("%010d", $order->id);
        $total_amount = $order->total - $order->credits;
        $content = array(
            'mch_id' => config('paylinx.mch_id'),
            'store_id' => config('paylinx.store_id'),
            'nonce_str' => 'ozkvr95oar40qa43n13rngoso9yge97x',
            'notify_url' => 'http://www.tangqi.com.au',
            'return_url' => 'http://www.tangqi.com.au/daigou/mall/payment_result/' . $user_id . '/' . $trade_id,
            'out_trade_no' => $trade_id,
            'body' => 'firstshopping_online',
            'spbill_create_ip' => '43.255.154.108',
            'total_fee' => $total_amount * 100,
            'fee_type' => 'AUD',
            'trade_type' => 'JSAPI'
        );
        $queryStr = '';
        ksort($content);
        foreach ($content as $key => $val) {
            if ((string)$val === '') continue;
            $queryStr .= $key . '=' . $val . '&';
        }
        $queryStr .= 'key='.config('paylinx.app_key');
        $sign = strtoupper(md5($queryStr));
        $content['sign'] = $sign;
        $xml_content = $this->array_to_XML($content);
        $ok = $this->curl_post("http://paylinx.cn/wxpay/gateway/unifiedorder/", $xml_content);
        $xml = new \SimpleXMLElement($ok);
        $success = 0;
        $repeat = 0;
        if ($xml->result_code == "SUCCESS") {
            $success = 1;
            $order->payment_link = "http://paylinx.cn/wxpay/h5/?mch_id=".config('paylinx.mch_id')."&out_trade_no={$trade_id}";
            $user->balance -= $order->credits;
            $user->save();
            $order->save();
        }
        if (strpos($xml->err_code_des, '订单号重复') !== false) {
            $repeat = 1;
        };
        if ($success || $repeat) {
            return redirect("http://paylinx.cn/wxpay/h5/?mch_id=".config('paylinx.mch_id')."&out_trade_no={$trade_id}");
        }
        return redirect(route('index'));
    }

    public function array_to_XML($array)
    {
        $xml = "<?xml version='1.0'?>" . "<xml>";
        foreach ($array as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    function curl_post($url, $post)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post,
            CURLOPT_CONNECTTIMEOUT => 0,
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
