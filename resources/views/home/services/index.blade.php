@extends('layouts.app')

@section('content')

    <div class="service-page">

        @foreach($orders as $order)
            <div class="container-fluid bg-white mb-3">
                <div class="row pl-3 pr-3 pt-2 pb-2">
                    <b>
                        订单号 {{sprintf("%010d",$order->id)}}<span class="text-success">（已完成）</span>
                    </b>
                </div>
                <hr class="m-0">

                <div class="row pl-3 pr-3 pt-2 pb-2">
                    <div class="w-100">
                        <span>收件人：{{$order->address->name}}</span>
                        <span class="float-right">下单日期：{{$order->created_at}}</span>
                    </div>
                    <div class="w-100">
                        <span>发件人：{{$order->sender_address->name}}</span>
                        <span class="float-right">总价：$AUD{{number_format($order->total,2,'.','') }}</span>
                    </div>
                </div>
                <hr class="m-0">
                <div class="row pl-3 pr-3 pt-2 pb-2">
                    <div class="col pl-0 pr-0">
                        @if($order->service)
                            <a href="{{route('home_service_show',['service_id' => $order->service->id])}}" class="btn btn-lg btn-secondary w-100" disabled>已申请售后</a>
                        @else
                            <a href="{{route('home_service_create',['id' => $order->id ])}}"
                               class="btn btn-lg btn-danger w-100">申请售后</a>
                        @endif


                    </div>
                    <div class="col pr-0">
                        <a href="{{route('home_order_show',['id' => $order->id])}}"
                           class="btn btn-lg btn-info w-100">查看订单</a>
                    </div>
                </div>
            </div>

        @endforeach

    </div>


    @include('home.layouts.bot-nav')
@endsection