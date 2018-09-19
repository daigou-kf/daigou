@extends('layouts.app')

@section('content')

    <div class="container-fluid mt-2 mb-5">
        <div class="card">
            <h5 class="card-header"> 订单号：{{sprintf('%010d',$service->order->id)}} </h5>
            <div class="card-body">
                <div class="mb-2">
                    <span class="font-weight-bold">售后理由</span>
                    <span class="float-right">{{$service->cause}}</span>
                </div>
                <div class="mb-2">
                    <span class="font-weight-bold">申请金额</span>
                    <span class="float-right">{{$service->refund}}</span>
                </div>
                <div class="mb-2">
                    <span class="font-weight-bold">退款说明： </span>{{$service->note}}
                </div>
                <div class="mb-2">
                    <span class="font-weight-bold">图片</span>
                </div>
                <div class="row">
                    @foreach(explode('|',$service->images) as $image )
                        <div class="col-6">
                            <a href="/daigou/storage/app/{{$image}}">
                                <img class="img-thumbnail" src="/daigou/storage/app/{{$image}}"
                                     style="height:150px;width:150px">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <div class="mb-2">
                    <span class="font-weight-bold">状态</span>
                    <span class="float-right">@if($service->status == 0) 处理中 @elseif($service->status == 1)
                            已处理 @endif </span>
                </div>
                @if($service->status == 1)
                    <div class="mb-2">
                        <span class="font-weight-bold">反馈</span>
                        <span class="float-right"> {{$service->result}} </span>
                    </div>
                @endif
            </div>
        </div>

    </div>

    @include('home.layouts.bot-nav')
@endsection