@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <h2>{{ $user->name }} </h2>
        </div>
        @include('layouts.feedback')
        <div class="col-10 offset-1">
            <!-- 用户信息 -->
            <hr>
            <table class="table table-bordered table-hover text-center">
                <h1>用户信息</h1>
                <thead>
                <tr>
                    <td>
                        <h1>用户名</h1>
                    </td>
                    <td>
                        <h1>邮箱</h1>
                    </td>
                    <td>
                        <h1>电话</h1>
                    </td>
                    <td>
                        <h1>级别</h1>
                    </td>
                    <td>
                        <h1>操作</h1>
                    </td>
                </tr>
                </thead>
                <tr>
                    <td><h1>{{$user['name']}}</h1></td>
                    <td><h1>{{$user['email']}}</h1></td>
                    <td><h1>{{$user['phone']}}</h1></td>
                    <td><h1> @if ($user['admin']) 管理员 @else 普通用户 @endif</h1></td>
                    <td>
                        <div class="btn-group-vertical d-flex">
                            <a href="{{action('UserController@show', $id)}}" class="btn btn-info">编辑</a>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- 用户订单 -->
            <hr>
            <table class="table table-bordered table-hover text-center">
                <h1>订单</h1>
                <thead>
                <tr>
                    <td>
                        <h1>订单号</h1>
                    </td>
                    <td>
                        <h1>商品</h1>
                    </td>
                    <td>
                        <h1>收货地址</h1>
                    </td>
                    <td>
                        <h1>总价</h1>
                    </td>
                </tr>
                </thead>

                @foreach($orders as $order)
                    <tr>
                        <td><h1>{{$order['id']}}</h1></td>
                        <td><h1>待添加</h1></td>
                        <td><h1>@if ($order->address) {{$order->address->name}} , {{$order->address->detail}} @else
                                    未添加地址信息 @endif</h1></td>
                        <td><h1>{{$order['total']}}</h1></td>
                    </tr>
                @endforeach

            </table>

            <!-- 购物车 -->
            <hr>
            <table class="table table-bordered table-hover text-center">
                <h1>购物车</h1>
                <thead>
                <tr>
                    <td>
                        <h1>商品</h1>
                    </td>
                    <td>
                        <h1>数量</h1>
                    </td>
                    <td>
                        <h1>单价</h1>
                    </td>
                </tr>
                </thead>
                @foreach($cart_products as $cart_product)
                    <tr>
                        <td><h1>{{$cart_product['name']}}</h1></td>
                        <td><h1>{{$cart_product->get_cart_quantity($user->id)}}</h1></td>
                        <td><h1>{{$cart_product['price']}}</h1></td>
                    </tr>
                @endforeach
            </table>

            <!-- 用户收藏 -->
            <hr>
            <table class="table table-bordered table-hover text-center">
                <h1>收藏商品</h1>
                <thead>
                <tr>
                    <td>
                        <h1>商品</h1>
                    </td>
                    <td>
                        <h1>图片</h1>
                    </td>
                    <td>
                        <h1>单价</h1>
                    </td>
                </tr>
                </thead>
                @foreach($fav_products as $fav_product)
                    <tr>
                        <td><h1>{{$fav_product['name']}}</h1></td>
                        <td><img src="../storage/app/{{$fav_product['img_url']}}" style="width:100px;height:100px"></td>
                        <td><h1>{{$fav_product['price']}}</h1></td>
                    </tr>
                @endforeach
            </table>

            <!-- 用户地址 -->
            <hr>
            <table class="table table-bordered table-hover text-center">
                <h1>用户地址</h1>
                <thead>
                <tr>
                    <td>
                        <h1>姓名</h1>
                    </td>
                    <td>
                        <h1>地址</h1>
                    </td>
                </tr>
                </thead>
                @foreach($addresses as $address)
                    <tr>
                        <td><h1>{{$address['name']}}</h1></td>
                        <td><h1>{{$address['detail']}}</h1></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection