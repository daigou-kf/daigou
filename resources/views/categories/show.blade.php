@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('categories.category_tab')
        </div>
        <hr>
        @include('layouts.feedback')
        <table class="table table-bordered table-hover text-center">
            <thead>
            <h1>{{$category->name}} 的产品</h1>
            <tr>
                <td>
                    <h1>ID</h1>
                </td>
                <td>
                    <h1>名称</h1>
                </td>
                <td>
                    <h1>图片</h1>
                </td>
                <td>
                    <h1>价格</h1>
                </td>
                <td>
                    <h1>销量</h1>
                </td>
                <td>
                    <h1>类别</h1>
                </td>
                <td>
                    <h1>操作</h1>
                </td>
            </tr>
            </thead>
            @foreach($products as $product)
                <tr>
                    <td><h1>{{$product['id']}}</h1></td>
                    <td><h1>{{$product['name']}}</h1></td>
                    <td class="d-flex justify-content-center"><img src="../storage/app/{{$product['img_url']}}"
                                                                   style="width:100px;height:100px"></td>
                    <td><h1>{{$product['price']}}</h1></td>
                    <td><h1>{{$product['sale']}}</h1></td>
                    <td><h1>{{$product->category->name}}</h1></td>
                    <td>
                        <div class="btn-group-vertical d-flex">
                            <a href="{{action('ProductController@edit', $product['id'])}}" class="btn btn-info">编辑</a>
                        </div>
                    </td>
                </tr>

            @endforeach

        </table>
    </div>

@endsection
