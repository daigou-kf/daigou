<?php

namespace App\Http\Controllers;

use App\Collection;
use App\CollectionProduct;
use App\Product;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CollectionController extends Controller
{
    public function index(){
        $collections = Collection::all();
        foreach ($collections as $collection){
            $collection['display'] = boolval($collection['display']);
        }
        return view('collections.index',compact('collections'));
    }

    public function show($id){
        $collection = Collection::find($id);
        $products = $collection->products;
        $all_products = Product::all();
        return view('collections.show',compact('collection','products','all_products'));
    }

    public function create(){
        return view('collections.create');
    }

    public function store(Request $request){
        $collection = new Collection();
        if($request->hasfile('img_url'))
        {
            if($request->file('img_url')->isValid()){
                $img_path = $request->file('img_url')->store('collection_img');
            } else {
                return redirect(route('collections.index'))->with('fail','系列上传失败');
            }

        }
        if(isset($img_path)){
            $collection->img_url = $img_path;
        }
        $collection->name = $request->get('name');
        $collection->search_name = $request->get('search_name');
        if($request->get('display') == 'on'){
            $collection->display = true;
        } else {
            $collection->display = false;
        }
        $collection->save();
        return redirect(route('collections.index'))->with('success','系列上传成功');
    }

    public function edit($id){
        $collection = Collection::find($id);
        return view('collections.edit',compact('collection'));
    }

    public function update(Request $request, $id){
        $collection = Collection::find($id);
        if($request->hasfile('img_url'))
        {
            if($request->file('img_url')->isValid()){
                $img_path = $request->file('img_url')->store('collection_img');
            } else {
                return redirect(route('collections.index'))->with('fail','系列更新失败');
            }

        }
        if(isset($img_path)){
            $collection->img_url = $img_path;
        }
        $collection->name = $request->get('name');
        $collection->search_name = $request->get('search_name');
        if($request->get('display') == 'on'){
            $collection->display = true;
        } else {
            $collection->display = false;
        }
        $collection->save();
        return redirect(route('collections.index'))->with('success','系列更新成功');
    }

    public function update_products(Request $request, $id){
        $collection = Collection::find($id);
        CollectionProduct::where('collection_id',$id)->delete();
        $products = Product::find($request->check_list);
        $collection->products()->saveMany($products);
        return redirect(route('collections.show',['id'=>$id]))->with('success','更新系列产品成功');
    }
}
