@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('products.product_tab')
        </div>
    </div>
    <div class="container-fluid">
        <hr>
        @include('layouts.feedback')
        <table class="table table-bordered table-hover text-center">
            <thead>
            <tr>
                <td>
                    <a class="text-dark" href="{{route('products.sort',['order'=>'id'])}}"><h1>ID</h1></a>
                </td>
                <td>
                    <a class="text-dark" href="{{route('products.sort',['order'=>'name'])}}"><h1>名称</h1></a>
                </td>
                <td>
                    <h1>规格</h1>
                </td>
                <td>
                    <h1>图片</h1>
                </td>
                <td>
                    <a class="text-dark" href="{{route('products.sort',['order'=>'RRP'])}}"><h1>RRP价格</h1></a>
                </td>
                <td>
                    <a class="text-dark" href="{{route('products.sort',['order'=>'price'])}}"><h1>价格</h1></a>
                </td>
                <td>
                    <h1>打折价格</h1>
                </td>
                <td>
                    <a class="text-dark" href="{{route('products.sort',['order'=>'weight'])}}"><h1>运输重量</h1></a>
                </td>
                <td>
                    <h1>销量</h1>
                </td>
                <td>
                    <h1>显示销量</h1>
                </td>
                <td>
                    <h1>品牌</h1>
                </td>
                <td>
                    <h1>类别</h1>
                </td>
                <td>
                    <h1>操作</h1>
                </td>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td><h1>{{$product['id']}}</h1></td>
                    <td><h1>{{$product['name']}}</h1></td>
                    <td><h3>{{$product['spec']}}</h3></td>
                    <td class="d-flex justify-content-center"><a href="/daigou/storage/app/{{$product['img_url']}}" target="_blank"><img src="/daigou/storage/app/{{$product['img_url']}}"
                                                                                                                                         style="width:100px;height:100px"></a></td>
                    <td><h3>{{$product['RRP']}}</h3></td>
                    <td><h3>{{$product['price']}}</h3></td>
                    <td><h3>{{$product['sale_price']}}</h3></td>
                    <td><h3>{{$product['weight']}}</h3></td>
                    <td><h3>{{$product['real_sale']}}</h3></td>
                    <td><h3>{{$product['sale']}}</h3></td>
                    <td><h3>{{$product->brand->name}}</h3></td>
                    <td><h3>{{$product->category->name}}</h3></td>
                    <td>
                        <div class="btn-group-vertical d-flex">
                            <a href="{{action('ProductController@edit', $product['id'])}}" class="btn btn-info">编辑</a>
                            <form action="{{action('ProductController@destroy',$product['id'])}}" class="w-100" method="post">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button onclick="return confirm('确定删除吗？')" type="submit" class="btn btn-danger">删除</button>
                            </form>
                        </div>
                    </td>
                </tr>

            @endforeach
            </thead>
        </table>
    </div>
@endsection