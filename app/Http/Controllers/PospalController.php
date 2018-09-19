<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\Product;
use App\Order;
use App\OrderProduct;

class PospalController extends Controller
{
    public static function curl_post_inventory($url, $post)
    {
        $sign = strtoupper(md5(config('pospal.app_key') . $post));
        $headers = [
            'User-Agent: openApi',
            'Content-Type: application/json; charset=utf-8',
            'accept-encoding: gzip,deflate',
            'time-stamp:' . time(),
            'data-signature:' . $sign
        ];
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $post,
            CURLOPT_CONNECTTIMEOUT => 0,
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//!!!!!!
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function get_inventory_by_id(Request $request)
    {
        try{
            $id = $request->id;
            $barcode = Product::find($id)->pospal_id;
            if($barcode == null){
                return response()->json(['message'=>'error']);
            }
            $product_data = PospalController::find_product_by_barcode($barcode);
            return response()->json(['message'=>'success','data'=>$product_data["stock"]], 200);
        } catch (\Exception $e){
            return response()->json(['message'=>'error']);
        }

    }

    public static function find_product_by_barcode($barcode){
        $content = array(
            "appId" => config('pospal.app_id'),
            "barcode" => $barcode
        );
        $para = json_encode($content);
        $ok = PospalController::curl_post_inventory("https://area9-win.pospal.cn:443/pospal-api2/openapi/v1/productOpenApi/queryProductByBarcode", $para);
        $result = json_decode($ok, true, 512, JSON_BIGINT_AS_STRING);
        return $result["data"];
    }

    public static function change_multiple_inventory($id)
    {
        $order = Order::find($id);
        $info = [];
        $products = $order->products;
        foreach ($products as $product) {
            $temp = [
                "productBarcode" => $product->pospal_id,
                "stockIncrement" => OrderProduct::where('order_id', $id)->where("product_id", $product->id)->first()->quantity * -1
            ];
            array_push($info, $temp);

        }
        $content = array(
            "appId" => config('pospal.app_id'),
            "stockIncrements" => $info

        );
        $para = json_encode($content);
        $ok = PospalController::curl_post_inventory("https://area9-win.pospal.cn:443/pospal-api2/openapi/v1/productOpenApi/updateStockByBarcodeAndIncrement", $para);
        $result = json_decode($ok, true);
        if ($result['status'] != "success") {
            Log::debug("something went wrong when writing to pospal stock");
        }
    }

    public static function change_user_points($method, $phone, $member_id, $points){
        if($method == 'phone'){
            try{
                $body = array(
                    "appId" => config('pospal.app_id'),
                    "customerTel" => $phone
                );
                $body = json_encode($body);
                $response = PospalController::curl_post_inventory("https://area9-win.pospal.cn:443/pospal-api2/openapi/v1/customerOpenapi/queryBytel", $body);
                $response = json_decode($response,true, 512, JSON_BIGINT_AS_STRING);
                if(count($response['data']) != 1){
                    return null;
                }
                $c_uid = $response['data'][0]['customerUid'];
                $body = array(
                    "appId" => config('pospal.app_id'),
                    "customerUid" => $c_uid,
                    "balanceIncrement" => 0,
                    "pointIncrement" => $points,
                    "dataChangeTime" => strval(now()),
                );
                $body = json_encode($body);
                $response = PospalController::curl_post_inventory("https://area9-win.pospal.cn:443/pospal-api2/openapi/v1/customerOpenApi/updateBalancePointByIncrement",$body);
                $response = json_decode($response,true, 512, JSON_BIGINT_AS_STRING);
                return $response['data'];
            }catch (\Exception $e){
                Log::debug($e);
                return null;
            }
        } elseif($method == 'member_id'){
            try{
                $body = array(
                    "appId" => config('pospal.app_id'),
                    "customerNum" => $member_id
                );
                $body = json_encode($body);
                $response = PospalController::curl_post_inventory("https://area9-win.pospal.cn:443/pospal-api2/openapi/v1/customerOpenApi/queryByNumber", $body);
                $response = json_decode($response,true, 512, JSON_BIGINT_AS_STRING);
                $c_uid = strval($response['data']['customerUid']);
                $body = array(
                    "appId" => config('pospal.app_id'),
                    "customerUid" => $c_uid,
                    "balanceIncrement" => 0,
                    "pointIncrement" => $points,
                    "dataChangeTime" => strval(now()),
                );
                $body = json_encode($body);
                $response = PospalController::curl_post_inventory("https://area9-win.pospal.cn:443/pospal-api2/openapi/v1/customerOpenApi/updateBalancePointByIncrement",$body);
                $response = json_decode($response,true, 512, JSON_BIGINT_AS_STRING);
                return $response['data'];
            }catch (\Exception $e){
                Log::debug($e);
                return null;
            }
        } else{
            return null;
        }
    }

    public static function get_user_points($method, $phone, $member_id){
        if($method == 'phone'){
            try{
                $body = array(
                    "appId" => config('pospal.app_id'),
                    "customerTel" => $phone
                );
                $body = json_encode($body);
                $response = PospalController::curl_post_inventory("https://area9-win.pospal.cn:443/pospal-api2/openapi/v1/customerOpenapi/queryBytel", $body);
                $response = json_decode($response,true, 512, JSON_BIGINT_AS_STRING);
                if(count($response['data']) != 1){
                    return null;
                }
                if($response['data'][0]['point'] == 0){
                    return 'zero';
                }
                return $response['data'][0]['point'];
            }catch (\Exception $e){
                Log::debug($e);
                return null;
            }
        } elseif($method == 'member_id'){
            try{
                $body = array(
                    "appId" => config('pospal.app_id'),
                    "customerNum" => $member_id
                );
                $body = json_encode($body);
                $response = PospalController::curl_post_inventory("https://area9-win.pospal.cn:443/pospal-api2/openapi/v1/customerOpenApi/queryByNumber", $body);
                $response = json_decode($response,true, 512, JSON_BIGINT_AS_STRING);
                if($response['data']['point'] == 0){
                    return 'zero';
                }
                return $response['data']['point'];
            }catch (\Exception $e){
                Log::debug($e);
                return null;
            }
        } else{
            return null;
        }
    }

    public static function get_cuid_by_phone($phone){
        try{
            $body = array(
                "appId" => config('pospal.app_id'),
                "customerTel" => $phone
            );
            $body = json_encode($body);
            $response = PospalController::curl_post_inventory("https://area9-win.pospal.cn:443/pospal-api2/openapi/v1/customerOpenapi/queryBytel", $body);
            $response = json_decode($response,true, 512, JSON_BIGINT_AS_STRING);
            if(!isset($response['data'])){
                return null;
            }
            if(count($response['data']) != 1){
                return null;
            }
            return $response['data'][0]['customerUid'];
        }catch (\Exception $e){
            Log::debug($e);
            return null;
        }
    }
}
