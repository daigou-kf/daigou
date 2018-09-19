@extends('layouts.app')

@section('content')

    @include('layouts.feedback')

    @if(isset($testing) && $testing == true)
        <staff-retail-index></staff-retail-index>

    @else
        <div class="container-fluid mt-2 mb-5">
            @foreach($orders as $order)
                <div class="card">
                    <div class="card-header">订单号：{{sprintf("%010d",$order->id)}}</div>
                    <div class="card-body">
                        <div class="w-100 mb-2">
                            <span>收件人</span>
                            <span class="float-right">{{$order['sending_address']->name}}</span>
                        </div>
                        <div class="w-100 mb-2">
                            <span>收件人地址</span>
                            <span class="float-right">{{$order['sending_address']->province}} {{$order['sending_address']->city}} {{$order['sending_address']->suburb}}</span>
                        </div>
                        <div class="w-100 mb-2">
                            <span>详细地址</span>
                            <span class="float-right">{{$order['sending_address']->detail}}</span>
                        </div>
                        @foreach($order['products'] as $product)
                            <div class="w-100 mb-2">
                                <div class="row">
                                    <div class="col-3">
                                        <a href="/daigou/storage/app/{{$product->img_url}}" target="_blank">
                                            <img class="img-thumbnail" src="/daigou/storage/app/{{$product->img_url}}">
                                        </a>
                                    </div>
                                    <div class="col-9">
                                        <span class="float-right">{{$product->name}} * {{$product['num']}}</span>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                        <div class="w-100 mb-2">
                            <span>增值服务</span>
                            <span class="float-right">@if($order->addon)有  @else无 @endif</span>
                        </div>
                        <div class="w-100 mb-2">
                            <span>备注</span>
                            <span class="float-right">@if($order->note) {{$order->note}} @else 无备注 @endif</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form method="post" action="{{route('staff_upload_deli_no')}}" enctype="multipart/form-data">
                        @csrf
                        <!-- images -->
                            @if($order->addon)
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <span class="text-left"><b>增值服务图片上传（可上传多张）</b></span>
                                    </div>
                                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                                        <div class="w-100">
                                            <input type="file" class="border-0 w-100" name="images[]" id="images"
                                                   multiple
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <div class="mb-2">
                                    <span class="text-left"><b>物流单图片上传（可上传多张）</b></span>
                                </div>
                                <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                                    <div class="w-100">
                                        <input type="file" class="border-0 w-100" name="deli_images[]" id="deli_images"
                                               multiple
                                               required>
                                    </div>
                                </div>
                            </div>

                            <input name="order_id" type="hidden" value="{{$order->id}}" required>
                            <input type="text" class="form-control mb-2" name="delivery_no" id="delivery_no"
                                   placeholder="填写物流号(如有多个,请用;分开)" required>
                            <input type="number" step="0.01" class="form-control mb-2" name="delivery_fee"
                                   id="delivery_fee"
                                   placeholder="填写运费($AUD)" required>
                            <button type="submit" class="btn btn-info btn-block">上传物流号</button>
                        </form>
                    </div>
                </div>

            @endforeach
        </div>
        @include('staffs.layouts.logout')
    @endif

@endsection