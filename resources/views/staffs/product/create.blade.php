@extends('layouts.app')

@section('content')
    @include('staffs.layouts.logout')
    @include('staffs.product.layouts.tab')
    <div class="container">
        <div class="row justify-content-center">

            <hr class="w-100">
            <div class="w-100">
                <div class="card">
                    <div class="card-header">添加产品</div>
                    <div class="card-body">
                        <form method="post" action="{{route('staff_store_product')}}" enctype="multipart/form-data">
                            @csrf
                            @include('layouts.feedback')
                            <div class="form-group row">
                                <label for="img_url" class="col-md-4 col-form-label text-md-right">产品图片</label>

                                <div class="col-md-6">
                                    <input id="img_url" type="file"
                                           class="form-control{{ $errors->has('img_url') ? ' is-invalid' : '' }}"
                                           name="img_url" required autofocus>

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
                                           name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">详情介绍</label>

                                <div class="col-md-6">
                                    <input id="description" type="text"
                                           class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                           name="description" value="{{ old('description') }}" autofocus>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">价格</label>

                                <div class="col-md-6">
                                    <input id="price" type="text"
                                           class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                           name="price" value="{{ old('price') }}" required autofocus>

                                    @if ($errors->has('price'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">重量(g)</label>

                                <div class="col-md-6">
                                    <input id="weight" type="text"
                                           class="form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}"
                                           name="weight" value="{{ old('weight') }}" required autofocus>

                                    @if ($errors->has('weight'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('weight') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">品牌</label>

                                <div class="col-md-6">
                                    <select id="brand_id"
                                            class="form-control{{ $errors->has('brand_id') ? ' is-invalid' : '' }}"
                                            name="brand_id" value="{{ old('brand_id') }}" required autofocus>
                                        <option>请选择品牌</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
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
                                <label for="price" class="col-md-4 col-form-label text-md-right">类别</label>

                                <div class="col-md-6">
                                    <select id="category_id"
                                            class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                            name="category_id" value="{{ old('category_id') }}" required autofocus>
                                        <option>请选择类别</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
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
                                <label for="name" class="col-md-4 col-form-label text-md-right">银豹ID</label>

                                <div class="col-md-6">
                                    <input id="pospal_id" type="number"
                                           class="form-control{{ $errors->has('pospal_id') ? ' is-invalid' : '' }}"
                                           name="pospal_id" value="{{ old('pospal_id') }}">

                                    @if ($errors->has('pospal_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('pospal_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        添加
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
