<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function sort($order)
    {
        if ($order == 'id') {
            $products = Product::all();
            return view('products.index', compact('products'));
        }
        if ($order == 'name') {
            $products = Product::orderBy('name')->get();
            return view('products.index', compact('products'));
        }
        if ($order == 'RRP') {
            $products = Product::orderBy('RRP')->get();
            return view('products.index', compact('products'));
        }
        if ($order == 'price') {
            $products = Product::orderBy('price')->get();
            return view('products.index', compact('products'));
        }
        if ($order == 'weight') {
            $products = Product::orderBy('weight')->get();
            return view('products.index', compact('products'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_array = $request->all();
        if ($request->hasfile('img_url')) {
            if ($request->file('img_url')->isValid()) {
                list($width, $height, $type, $attr) = getimagesize($request->file('img_url'));
                if ($width < 600 || $height < 600 || $width / $height != 1) {
                    return redirect('products/create')->with('fail', '图片尺寸必须大于600*600，长宽比例1：1')->withInput();
                }
                $img_path = $request->file('img_url')->store('product_img');
            } else {
                return redirect('products/create')->with('fail', '图片不合格')->withInput();
            }
        }
        if (isset($img_path)) {
            $data_array['img_url'] = $img_path;
        }
        $validator = $this->validator($data_array);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect(route('products.create'))->with('errors', $errors)->withInput();
        }
        Product::create($data_array);
        return redirect('products')->with('success', '已添加产品');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product = Product::find($id);
        return view('products.edit', compact('categories', 'brands', 'product', 'id'));
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
        $product = Product::find($id);
        $data_array = $request->all();
        if ($request->hasfile('img_url')) {
            if ($request->file('img_url')->isValid()) {
                list($width, $height, $type, $attr) = getimagesize($request->file('img_url'));
                if ($width < 600 || $height < 600 || $width / $height != 1) {
                    return redirect('products/'.$id.'/edit')->with('fail', '图片尺寸必须大于600*600，长宽比例1：1')->withInput();
                }
                $img_path = $request->file('img_url')->store('product_img');
            } else {
                return redirect('products/' . $id . '/edit')->with('fail', '图片上传失败');
            }
        }
        if (isset($img_path)) {
            $data_array['img_url'] = $img_path;
        }
        $validator = $this->update_validator($data_array, $product);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect(route('products.edit', ['id' => $product->id]))->with('errors', $errors)->withInput();
        }
        $product->update($data_array);
        return redirect()->back()->with('success', '已更新产品');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect(route('products.index'))->with('success', '已删除产品');
    }

    public function index_trashed()
    {
        $products = Product::onlyTrashed()->get();
        return view('products.index_trashed', compact('products'));

    }

    public function restore($id)
    {
        Product::withTrashed()->find($id)->restore();
        return redirect(route('products.index_trashed'))->with('success', '已恢复产品');
    }

    public function show_points($pospal_id)
    {
        if (Product::where('pospal_id', $pospal_id)->get()->isEmpty()) {
            return response()->json(['message' => 'not found'], 403);
        } else {
            $product = Product::where('pospal_id', $pospal_id)->first();
            return response()->json(['points' => $product->reward_points]);
        }
    }

    public function validator($data_array)
    {
        if ($data_array['pospal_id'] == null) {
            unset($data_array['pospal_id']);
        }
        Log::debug($data_array);
        return Validator::make($data_array, [
            'pospal_id' => 'unique:products'
        ]);
    }

    public function update_validator($data_array, $product)
    {
        if ($data_array['pospal_id'] == null) {
            unset($data_array['pospal_id']);
        }
        return Validator::make($data_array, [
            'pospal_id' => 'unique:products,pospal_id,' . $product->id
        ]);
    }

    public static function get_tag_img($product)
    {
        if ($product->collection->isNotEmpty()) {
            $img_urls = array();
            $collections = $product->collection;
            foreach($collections as $collection){
                $search_name = $collection->search_name;
                if ($search_name == 'new') {
                    $img_urls[] = Storage::url('app/assets/new_tag.png');
                }
                if ($search_name == 'rec') {
                    $img_urls[] = Storage::url('app/assets/rec_tag.png');
                }
                if ($search_name == 'hot') {
                    $img_urls[] = Storage::url('app/assets/hot_tag.png');
                }
                if ($search_name == 'sale') {
                    $img_urls[] = Storage::url('app/assets/sale_tag.png');
                }
            }
            return $img_urls;
        } else {
            return null;
        }
    }
}
