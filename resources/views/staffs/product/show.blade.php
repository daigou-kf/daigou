@extends('layouts.app')

@section('content')
    @include('staffs.layouts.logout')
    @include('staffs.product.layouts.tab')

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
                    <h1>品牌</h1>
                </td>
                <td>
                    <h1>类别</h1>
                </td>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td><h1>{{$product['name']}}</h1></td>
                    <td class="d-flex justify-content-center"><img src="{{asset('storage/app/'.$product->img_url)}}"
                                                                   style="width:100px;height:100px"></td>
                    <td><h1>{{$product['price']}}</h1></td>
                    <td><h1>{{$product->brand->name}}</h1></td>
                    <td><h1>{{$product->category->name}}</h1></td>
                </tr>

            @endforeach
            </thead>
        </table>
    </div>


@endsection
