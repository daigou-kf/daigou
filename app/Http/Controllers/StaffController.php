<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\Service;
use App\Brand;
use App\Category;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('staff');
    }


    public function edit_product(Request $request){
        $product = Product::find($request->id);
        $brands = Brand::all();
        $categories = Category::all();
        return view('staffs.product.edit',compact('product','brands','categories'));
    }

    public function update_product(Request $request, $id){
        $product = Product::find($id);
        if($request->hasfile('img_url'))
        {
            if($request->file('img_url')->isValid()){
                $img_path = $request->file('img_url')->store('product_img');
            } else {
                return redirect('products/'.$id.'/edit')->with('fail','图片上传失败');
            }

        }
        $product->name = $request->get('name');
        if(isset($img_path)){
            $product->img_url = $img_path;
        }
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->category_id = $request->get('category_id');
        $product->brand_id = $request->get('brand_id');
        $product->sale = $request->get('sale');
        $product->pospal_id = $request->get('pospal_id');
        $product->save();

        return redirect(route('staff_show'))->with('success','已更新产品');
    }


}
