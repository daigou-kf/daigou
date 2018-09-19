<?php

namespace App\Http\Controllers;

use http\Exception;
use Illuminate\Http\Request;
use App\Brand;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $brand = new Brand();
        if ($request->hasfile('img_url')) {
            if ($request->file('img_url')->isValid()) {
                $img_path = $request->file('img_url')->store('brand_img');
            } else {
                return redirect('brands/create')->with('fail', '图片上传失败');
            }

        }
        $brand->name = $request->get('name');
        if (isset($img_path)) {
            $brand->img_url = $img_path;
        }
        $brand->save();

        return redirect('brands')->with('success', '已添加品牌');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::find($id);
        $products = $brand->products->sortBy('name');
        return view('brands.show', compact('brand', 'products', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if ($request->hasfile('img_url')) {
            if ($request->file('img_url')->isValid()) {
                $img_path = $request->file('img_url')->store('brand_img');
            } else {
                return redirect('brands/' . $id . '/edit')->with('fail', '图片上传失败');
            }

        }
        $brand->name = $request->get('name');
        if (isset($img_path)) {
            if($brand->img_url != null){
                try{
                    Storage::delete($brand->img_url);
                }catch (\Exception $e){
                    Log::debug($e);
                }
            }
            $brand->img_url = $img_path;
        }
        $brand->save();
        return redirect('brands')->with('success', '更新品牌成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if($brand->products->isEmpty()){
            $brand->delete();
            return redirect('brands')->with('success', '删除品牌成功');
        } else {
            return redirect('brands')->with('fail', '删除品牌失败，请先删除该品牌下的产品');
        }

    }

    public function show_order()
    {
        $top_ten = collect();
        $brands = Brand::all();
        foreach (range(1, 9) as $index) {
            if ($brand = Brand::where('order', $index)->first()) {
                $top_ten->put($index, $brand);
            } else {
                $top_ten->put($index, '');
            }
        }
        return view('brands.order', compact('top_ten', 'brands'));
    }

    public function change_order(Request $request)
    {
        $index = $request->get('index');
        if ($brand = Brand::where('order', $index)->first()) {
            $brand->order = null;
            $brand->save();
        }
        $brand = Brand::find($request->get('brand_id'));
        if ($request->get('brand_id') != '-1') {
            $brand->order = $request->get('index');
            $brand->save();
        }

        return redirect(route('brands.order'))->with('success', '已更新索引');
    }

    public function sort($order){
        if($order == 'name'){
            $brands = Brand::orderBy('name')->get();
            return view('brands.index',compact('brands'));
        }
    }
}
