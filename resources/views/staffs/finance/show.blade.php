@extends('layouts.app')

@section('content')

    @include('layouts.feedback')
    @include('staffs.layouts.logout')

    @foreach($services as $service)
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
                        <span class="font-weight-bold">退款说明： </span><br>{{$service->note}}
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">图片</span>
                    </div>
                    <div class="row">
                        @foreach(explode('|',$service->images) as $image )
                            <div class="col-6 col-lg-2 col-md-3 col-sm-4">
                                <a href="/daigou/storage/app/{{$image}}">
                                    <img class="img-thumbnail" src="/daigou/storage/app/{{$image}}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <div class="mb-2">
                        <span class="font-weight-bold">反馈</span>
                    </div>
                    <form method="post" action="{{route('staff_upload_service')}}">
                        @csrf
                        <input type="hidden" name="service_id" value="{{$service->id}}">
                        <textarea class="form-control mb-2" name="result" required></textarea>
                        <button type="submit" class="btn btn-block btn-outline-info">提交</button>
                    </form>
                </div>
            </div>

        </div>
    @endforeach
@endsection