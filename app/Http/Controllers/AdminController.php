<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Product;
use App\Category;
use App\Brand;
use Nexmo;

class AdminController extends Controller
{

    public function report_tasks(){
        $content = array();
        $products = Product::where('pospal_id',null)->get();
        $content[] = ('未上传条码的产品: ');
        foreach ($products as $product){
            $content[] = ('产品ID: '.$product->id.'; ');
        }
        $content[] = ('总计: '.count($products)."\r\n");

        $products = Product::where('RRP','0')->get();
        $content[] = ('未上传RRP价格的产品: ');
        foreach ($products as $product){
            $content[] = ('产品ID: '.$product->id.'; ');
        }
        $content[] = ('总计: '.count($products)."\r\n");

        $products = Product::all();
        $content[] = ('产品图片不符合尺寸标准(1:1,至少600*600）的产品： ');
        $num = 0;
        foreach($products as $product){
            list($width, $height, $type, $attr) = getimagesize('storage/app/'.$product->img_url);
            if($width < 600 || $height < 600 || $width/$height != 1){
                $num++;
                $content[] = ('产品ID： '.$product->id.';');
            }
        }
        $content[] = ('总计: '.$num."\r\n");

        $products = Product::all();
        $content[] = ('运输重量不合格的产品： ');
        $num = 0;
        foreach($products as $product){
            if($product->weight == 1){
                $num++;
                $content[] = ('产品ID： '.$product->id.';');
            }
        }
        $content[] = ('总计: '.$num."\r\n");

        $brands = Brand::all();
        $content[] = ('产品为空的品牌: ');
        $num = 0;
        foreach ($brands as $brand){
            if($brand->products->isEmpty()){
                $num++;
                $content[] = ('品牌ID: '.$brand->id.'; ');
            }
        }
        $content[] = ('总计: '.$num."\r\n");

        $categories = Category::all();
        $content[] = ('产品为空的类别: ');
        $num = 0;
        foreach ($categories as $category){
            if($category->products->isEmpty()){
                $num++;
                $content[] = ('类别ID: '.$category->id.'; ');
            }
        }
        $content[] = ('总计: '.$num."\r\n");
        $content = implode("\r\n",$content);
        Storage::disk('public')->put('admin/report.txt',$content);
        return Storage::download('public/admin/report.txt');
    }

    public function fetch_pospal_uid(){
        ini_set('max_execution_time', 300);
        Log::debug("running fetching pospal uid by barcode...");
        $products = Product::where('pospal_id','!=',null)->where('uid',null)->get();
        foreach ($products as $product){
            $errors = array();
            try{
                $product_data = PospalController::find_product_by_barcode($product->pospal_id);
                $product->uid = $product_data['uid'];
                $product->save();
            } catch (\Exception $e){
                $errors[$product->name] = 'id:'.$product_data->id.', barcode:'.$product_data->pospal_id;
            }
            if(count($errors) != 0){
                Log::debug("fetching pospal uid errors: ");
                Log::debug(implode("\r\n",$errors));
            }
        }
    }

    public function pospal_index(){
        return view('pospal.index');
    }

    public function pospal_change_points(Request $request){
        $method = $request->search_method;
        if($method == 'phone'){
            $result = PospalController::change_user_points($method,$request->phone,null,$request->points);
            if($result == null){
                return redirect(route('pospal.index'))->with('fail','数据错误');
            }
            return redirect(route('pospal.index'))->with('result',$result);
        } elseif($method == 'member_id'){
            $result = PospalController::change_user_points($method,null,$request->member_id,$request->points);
            if($result == null){
                return redirect(route('pospal.index'))->with('fail','数据错误');
            }
            return redirect(route('pospal.index'))->with('result',$result);
        } else {
            return redirect(route('pospal.index'))->with('fail','数据错误');
        }
    }

    public function pospal_get_member_points(Request $request){
        $method = $request->search_method;
        if($method == 'phone'){
            $result = PospalController::get_user_points($method,$request->phone,null);
            if($result == 'zero'){
                Log::debug($result);
                $result = "零积分";
                return redirect(route('pospal.index'))->with('points',$result);
            }
            if($result == null){
                return redirect(route('pospal.index'))->with('fail','数据错误');
            }
            return redirect(route('pospal.index'))->with('points',$result);
        } elseif($method == 'member_id'){
            $result = PospalController::get_user_points($method,null,$request->member_id);
            if($result == 'zero'){
                Log::debug($result);
                $result = "零积分";
                return redirect(route('pospal.index'))->with('points',$result);
            }
            if($result == null){
                return redirect(route('pospal.index'))->with('fail','数据错误');
            }
            return redirect(route('pospal.index'))->with('points',$result);
        } else {
            return redirect(route('pospal.index'))->with('fail','数据错误');
        }
    }

    public function send_sms($phone, $text){
        Nexmo::message()->send(['to'=>$phone,'from'=>'000','text'=>$text]);
    }

    public function ebay(){
        return view('home.test.ebay_testing');
    }
}
