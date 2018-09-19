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
                    <h1>显示销量</h1>
                </td>
                <td>
                    <h1>操作</h1>
                </td>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td><h1>{{$product['name']}}</h1></td>
                    <td class="d-flex justify-content-center"><img src="/daigou/storage/app/{{$product['img_url']}}"
                                                                   style="width:100px;height:100px"></td>
                    <td><h1>{{$product['price']}}</h1></td>
                    <td><h1>{{$product['real_sale']}}</h1></td>
                    <td><h1>{{$product['sale']}}</h1></td>
                    <td>
                        <div class="btn-group-vertical d-flex">
                            <form method="post" action="{{route('products.restore',$product['id'])}}" class="w-100">
                                @csrf
                                <button onclick="return confirm('确定要恢复产品吗')" class="btn btn-info">恢复产品</button>
                            </form>
                        </div>
                    </td>
                </tr>

            @endforeach
            </thead>
        </table>
    </div>
@endsection