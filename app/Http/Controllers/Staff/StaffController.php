<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Order;
use App\Service;
use App\Brand;
use App\Category;

class StaffController extends Controller
{
    public function admin_login(){
        return view('admin.login');
    }

    public function show(){
        $user = Auth::user();
        if($user->staff == 1){
            $orders = Order::all()->where('status','1');
            foreach($orders as $order){
                $order['sending_address'] = $order->address;
                $order['sender_address'] = $order->address;
                $order['products'] = $order->products;
                foreach($order['products'] as $product){
                    $product['num'] = $product->get_order_quantity($order->id);
                }
            }
            if($user->email == 'test'){
                $testing = true;
            } else {
                $testing = false;
            }
            return view('staffs.retail.show',compact('orders','testing'));
        } elseif ($user->staff == 2) {
            $services = Service::all()->where('status','0');
            return view('staffs.finance.show',compact('services'));
        } elseif ($user->staff == 3){
            $products = Product::all();
            return view('staffs.product.show',compact('products'));
        }
    }

    public function upload_delivery_no(Request $request){
        $user = Auth::user();
        try{
            $order = Order::find($request->order_id)->where('status','1')->first();
        } catch (\Exception $e){
            Log::debug($e);
            return redirect(route('staff_show'))->with('fail','订单未找到');
        }

        try{
            $order->delivery_no = implode("|",explode(';',$request->delivery_no));
        } catch (\Exception $e){
            return redirect(route('staff_show'))->with('fail','订单号格式错误');
        }

        if ($request->has('images') && $files = $request->file('images')) {
            $images = array();
            foreach ($files as $file) {
                if ($file->isValid()) {
                    $img_path = $file->store('orders/addon');
                    $images[] = $img_path;
                } else {
                    return redirect(route('staff_show'))->with('fail', '增值服务图片上传失败');
                }
            }
            $order->images = implode("|", $images);
        }

        try{
            $files = $request->file('deli_images');
            $images = array();
            foreach ($files as $file) {
                if ($file->isValid()) {
                    $img_path = $file->store('orders/delivery_images');
                    $images[] = $img_path;
                } else {
                    return redirect(route('staff_show'))->with('fail', '物流单号图片上传失败');
                }
            }
            $order->deli_images = implode("|", $images);

        } catch (\Exception $e){
            return redirect(route('staff_show'))->with('fail', '物流单号图片上传失败');
        }

        $order->delivery_fee = $request->get('delivery_fee');
        $order->status = 2;
        $order->delivery_staff_id = $user->id;
        $order->save();
        $order->weight > 1000 ? $delivery_fee = $order->weight * config('delivery.rate') : $delivery_fee = 1000 * config('delivery.rate');
        if($order->delivery_fee < $delivery_fee){
            $customer = $order->user;
            $customer->balance += ($delivery_fee - $order->delivery_fee);
            $customer->save();
        }
        return redirect(route('staff_show'))->with('success','物流信息上传成功');
    }

    public function upload_service(Request $request){
        $service = Service::find($request->service_id);
        $service->result = $request->result;
        $service->status = 1;
        $service->save();
        return redirect(route('staff_show'))->with('success','处理售后申请成功');

    }

    public function create_product(){
        $brands = Brand::all();
        $categories = Category::all();
        return view('staffs.product.create',compact('brands','categories'));
    }

    public function store_product(Request $request)
    {
        $product = new Product();
        if($request->hasfile('img_url'))
        {
            if($request->file('img_url')->isValid()){
                $img_path = $request->file('img_url')->store('product_img');
            } else {
                return redirect('products/create')->with('fail','图片上传失败');
            }

        }
        $product->name = $request->get('name');
        if(isset($img_path)){
            $product->img_url = $img_path;
        }
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->weight = $request->get('weight');
        $product->category_id = $request->get('category_id');
        $product->brand_id = $request->get('brand_id');
        $product->pospal_id = $request->get('pospal_id');
        $product->save();

        return redirect(route('staff_show'))->with('success','已添加产品');
    }

    public function create_brand(){
        return view('staffs.product.brands.create');
    }

    public function store_brand(Request $request){
        $brand = new Brand();
        if($request->hasfile('img_url'))
        {
            if($request->file('img_url')->isValid()){
                $img_path = $request->file('img_url')->store('brand_img');
            } else {
                return redirect('brands/create')->with('fail','图片上传失败');
            }

        }
        $brand->name = $request->get('name');
        if(isset($img_path)){
            $brand->img_url = $img_path;
        }
        $brand->save();

        return redirect(route('staff_show'))->with('success','已添加品牌');
    }

    public function create_category(){
        return view('staffs.product.categories.create');
    }

    public function store_category(Request $request){
        $category = new Category();
        if($request->hasfile('img_url'))
        {
            if($request->file('img_url')->isValid()){
                $img_path = $request->file('img_url')->store('category_img');
            } else {
                return redirect('categories/create')->with('fail','图片上传失败');
            }

        }
        $category->name = $request->get('name');
        if(isset($img_path)){
            $category->img_url = $img_path;
        }
        $category->save();

        return redirect(route('staff_show'))->with('success','已添加类别');
    }
}
