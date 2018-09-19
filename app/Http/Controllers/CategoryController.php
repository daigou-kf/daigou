<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Category;
use App\User;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return redirect('categories')->with('success','已添加类别');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        $products = $category->products->sortBy('name');
        return view('categories.show',compact('category','products','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit',compact('category','id'));
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
        $category = Category::find($id);
        if($request->hasfile('img_url'))
        {
            if($request->file('img_url')->isValid()){
                $img_path = $request->file('img_url')->store('category_img');
            } else {
                return redirect('categories/'.$id.'/edit')->with('fail','图片上传失败');
            }

        }
        $category->name = $request->get('name');
        if(isset($img_path)){
            $category->img_url = $img_path;
        }
        $category->save();
        return redirect('categories')->with('success','更新类别成功');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category->products()->withTrashed()->get()->isEmpty()){
            $category->delete();
            return redirect('categories')->with('success', '删除类别成功');
        } else {
            return redirect('categories')->with('fail','请确定已经转移所有该类别下的产品（包括已删除产品）');
        }
    }

    public function order(){
        $categories = Category::all();
        return view('categories.order',compact('categories'));
    }
}
