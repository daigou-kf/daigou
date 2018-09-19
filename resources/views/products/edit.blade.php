@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('products.product_tab')
            <hr>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">编辑产品</div>
                    <div class="card-body">
                        <form method="post" action="{{ action('ProductController@update',$id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @include('layouts.feedback')
                            <input name="_method" type="hidden" value="PATCH">

                            <div class="form-group row">
                                <label for="img_url" class="col-md-4 col-form-label text-md-right">更新图片(1:1 , 至少600*600)</label>

                                <div class="col-md-6">
                                    <input id="img_url" type="file"
                                           class="form-control{{ $errors->has('img_url') ? ' is-invalid' : '' }}"
                                           name="img_url" autofocus>

                                    @if ($errors->has('img_url'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('img_url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">名称</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ $product->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="spec" class="col-md-4 col-form-label text-md-right">规格</label>

                                <div class="col-md-6">
                                    <input id="spec" type="text"
                                           class="form-control{{ $errors->has('spec') ? ' is-invalid' : '' }}"
                                           name="spec" value="{{ $product->spec }}" required autofocus>

                                    @if ($errors->has('spec'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('spec') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">详情介绍</label>

                                <div class="col-md-6">
                                    <input id="description" type="text"
                                           class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                           name="description" value="{{ $product->description }}" autofocus>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="RRP" class="col-md-4 col-form-label text-md-right">RRP价格</label>

                                <div class="col-md-6">
                                    <input id="RRP" type="number" step="0.01"
                                           class="form-control{{ $errors->has('RRP') ? ' is-invalid' : '' }}"
                                           name="RRP" value="{{ $product->RRP }}" required autofocus>

                                    @if ($errors->has('RRP'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('RRP') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">价格</label>

                                <div class="col-md-6">
                                    <input id="price" type="number" step="0.01"
                                           class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                           name="price" value="{{ $product->price }}" required autofocus>

                                    @if ($errors->has('price'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sale_price" class="col-md-4 col-form-label text-md-right">打折价格（选填）</label>

                                <div class="col-md-6">
                                    <input id="sale_price" type="number" step="0.01"
                                           class="form-control{{ $errors->has('sale_price') ? ' is-invalid' : '' }}"
                                           name="sale_price" value="{{ $product->sale_price }}">

                                    @if ($errors->has('sale_price'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('sale_price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reward_points" class="col-md-4 col-form-label text-md-right">积分（选填）</label>

                                <div class="col-md-6">
                                    <input id="reward_points" type="number" step="1"
                                           class="form-control{{ $errors->has('reward_points') ? ' is-invalid' : '' }}"
                                           name="reward_points" value="{{ $product->reward_points  }}">

                                    @if ($errors->has('reward_points'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('reward_points') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">重量(g)</label>

                                <div class="col-md-6">
                                    <input id="weight" type="number"
                                           class="form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}"
                                           name="weight" value="{{ $product->weight }}" required autofocus>

                                    @if ($errors->has('weight'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('weight') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="brand_id" class="col-md-4 col-form-label text-md-right">品牌</label>

                                <div class="col-md-6">
                                    <select id="brand_id"
                                            class="form-control{{ $errors->has('brand_id') ? ' is-invalid' : '' }}"
                                            name="brand_id" required autofocus>
                                        <option>请选择品牌</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" @if ($product->brand_id == $brand->id) selected @endif>{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('brand_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('brand_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category_id" class="col-md-4 col-form-label text-md-right">类别</label>

                                <div class="col-md-6">
                                    <select id="category_id"
                                            class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                            name="category_id" required autofocus>
                                        <option>请选择类别</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if ($product->category_id == $category->id) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">显示销量</label>

                                <div class="col-md-6">
                                    <input id="sale" type="number"
                                           class="form-control{{ $errors->has('sale') ? ' is-invalid' : '' }}"
                                           name="sale" value="{{ $product->sale }}">

                                    @if ($errors->has('sale'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('sale') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">银豹条码</label>

                                <div class="col-md-6">
                                    <input id="pospal_id" type="number"
                                           class="form-control{{ $errors->has('pospal_id') ? ' is-invalid' : '' }}"
                                           name="pospal_id" value="{{ $product->pospal_id }}">

                                    @if ($errors->has('pospal_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('pospal_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="expired_date" class="col-md-4 col-form-label text-md-right">保质期</label>

                                <div class="col-md-6">
                                    <input id="expired_date" type="text"
                                           class="form-control{{ $errors->has('expired_at') ? ' is-invalid' : '' }}"
                                           name="expired_date" value="{{ $product->expired_date }}">

                                    @if ($errors->has('expired_at'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('expired_at') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        更新
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection