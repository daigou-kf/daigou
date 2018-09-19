<?php

namespace App\Http\Controllers;

use App\OrderProduct;
use App\Product;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Nexmo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderPaid;
use App\Notifications\SendResetLink;


class GuestController extends Controller
{

    public function send_code(Request $request)
    {
        $db_phone = ltrim($request->phone, '61');
        $db_phone = '0' . $db_phone;
        $user = User::where('phone', $db_phone)->get()->count();
        if ($user > 0) {
            return response()->json('registered', 403);
        } else {
            try {
                $verification = Nexmo::verify()->start([
                    'number' => $request->phone,
                    'brand' => 'First Shopping'
                ]);
                $request->session()->put('verify:request_id', $verification->getRequestId());
                $request->session()->put('phone_input', $db_phone);
                return response()->json('success', 200);
            } catch (Nexmo\Client\Exception\Request $e) {
                return response()->json('error', 403);
            }


        }

    }

    public function payment_result(Request $request)
    {
        $trade_id = $request->trade_id;
        $user_id = $request->user_id;
        $order = User::find($user_id)->orders->find($trade_id);
        if ($order->status == 0) {
            $login = 'true';
            Auth::login(User::find($user_id), true);
        }
        $content = array(
            'mch_id' => config('paylinx.mch_id'),
            'nonce_str' => 'ozkvr95oar40qa43n13rngoso9yge97x',
            'out_trade_no' => $trade_id
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
        $ok = $this->curl_post("http://paylinx.cn/wxpay/gateway/orderquery/", $xml_content);
        $xml = new \SimpleXMLElement($ok);
        $success = 0;
        if ($xml->result_code == "SUCCESS" && $xml->trade_state == "SUCCESS") {
            Notification::route('mail', 'sales@tangqi.com.au')->notify(new OrderPaid($order));
            Notification::route('mail', 'paulpengwork@gmail.com')->notify(new OrderPaid($order));
            $success = 1;
            $order = Order::find($trade_id);
            $order->status = 1;
            $order->save();
            PospalController::change_multiple_inventory($order->id);
            UserController::add_points($user_id,$order->id);
            $this->update_sale($order->id);
        }
        if ($success == 1) {
            $message = '支付成功';
        } else {
            $message = '支付未成功';
        }
        return view('home.orders.payment_result', compact('message', 'login'));
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

    /* update product sale after purchase */
    public function update_sale($order_id)
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

    public function web_coming_soon()
    {
        return view('layouts.web_coming_soon');
    }

    /**
     * @throws \Exception
     */
    public function test()
    {
        $barcode = new BarcodeGenerator();
        $barcode->setText('97855085481');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setScale(5);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode->setLabel('97855085481');
        Storage::disk('public')->put('test/97855085481.png', base64_decode($barcode->generate()));
    }

    public function test1()
    {
        $qr_code = new QrCode();
        $user = User::where('phone','0421884740')->first();
        $json = json_encode(array("user_id"=>$user->id,"secret"=>$user->password));
        $code = encrypt($json);
        Log::debug($code);

        $qr_code
            ->setText('http://www.tangqi.com.au/daigou/test2/'.$code)
            ->setSize(200)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setLabel('My Wallet')
            ->setLabelFontSize(16)
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
        Storage::disk('public')->put('wallets/'.$user->phone.'.png',base64_decode($qr_code->generate()));

    }

    public function test2($query)
    {
        $json = decrypt($query);
        Log::debug($json);
        $json = json_decode($json);
        if(isset($json->user_id) && isset($json->secret)){
            try{
                $user = User::find($json->user_id);
                if($user->password == $json->secret){
                    Auth::login($user);
                    return redirect(route('home_dashboard'));
                } else {
                    return redirect(route('index'));
                }
            } catch(\Exception $e) {
                return redirect(route('index'));
            }
        } else {
            return redirect(route('index'));
        }
    }

    public function g_code()
    {
        ini_set('max_execution_time', 300);
        $barcode = new BarcodeGenerator();
        $current = "807877";
        $total = 0;
        while ($total != 1) {
            if (strpos($current, "4") === false) {
                $barcode->setText($current);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setScale(5);
                $barcode->setThickness(25);
                $barcode->setFontSize(24);
                $barcode->setLabel($current);
                $barcode->setForegroundColor('#FFD700');
                Storage::disk('public')->put('code/general/' . $current . 'test.png', base64_decode($barcode->generate()));
                $current = strval(intval($current) + 1);
                $total++;
            } else {
                $current = strval(intval($current) + 1);
            }
        }
    }

    public function pick_code()
    {
        ini_set('max_execution_time', 300);
        $start = "807877";
        $current = $start;
        $end = "822617";
        $special = 0;
        while ($special != 2000 && $current != $end) {
            if (strpos($current, "4") === false) {
                if (strpos($current, "666") !== false || (strpos($current, "888") !== false)) {
                    $image = Storage::disk('public')->exists('code/general/' . $current . '.png');
                    if ($image) {
                        Storage::move('public/code/general/' . $current . '.png', 'public/code/special_1/' . $current . '.png');
                        $special++;
                    }
                }
                $current = strval(intval($current) + 1);
            } else {
                $current = strval(intval($current) + 1);
            }
        }
        $current = $start;
        while ($special != 2000 && $current != $end) {
            if (strpos($current, "4") === false) {
                if (strpos($current, "66") !== false || (strpos($current, "88") !== false)) {
                    $image = Storage::disk('public')->exists('code/general/' . $current . '.png');
                    if ($image) {
                        Storage::move('public/code/general/' . $current . '.png', 'public/code/special_2/' . $current . '.png');
                        $special++;
                    }
                }
                $current = strval(intval($current) + 1);
            } else {
                $current = strval(intval($current) + 1);
            }
        }
        $current = $start;
        while ($special != 2000 && $current != $end) {
            if (strpos($current, "4") === false) {
                if (strpos($current, "86") !== false || (strpos($current, "68") !== false)) {
                    $image = Storage::disk('public')->exists('code/general/' . $current . '.png');
                    if ($image) {
                        Storage::move('public/code/general/' . $current . '.png', 'public/code/special_3/' . $current . '.png');
                        $special++;
                    }
                }
                $current = strval(intval($current) + 1);
            } else {
                $current = strval(intval($current) + 1);
            }
        }
        $current = $start;
        while ($special != 2000 && $current != $end) {
            if (strpos($current, "4") === false) {
                foreach (range(1, 9) as $num) {
                    if (strpos($current, str_repeat($num, 2)) !== false) {
                        $image = Storage::disk('public')->exists('code/general/' . $current . '.png');
                        if ($image) {
                            Storage::move('public/code/general/' . $current . '.png', 'public/code/special_3/' . $current . '.png');
                            $special++;
                            break;
                        }
                    }
                }
                $current = strval(intval($current) + 1);
            } else {
                $current = strval(intval($current) + 1);
            }
        }

    }

    public function page_test(){
        $page = "tangqi_index";
        return view('home.test.testing_page',compact('page'));
    }

    public function page_view(){
        $login = 1;
        $message = '支付成功';
        return view('home.orders.payment_result',compact('login','message'));
    }
}
