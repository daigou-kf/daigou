@extends('layouts.app')

@section('content')

    <div id="service-application-page">
        <form method="post" action="{{route('home_service_store')}}" enctype="multipart/form-data">
            @csrf
            <input name="order_id" id="order_id" value="{{$order->id}}" class="d-none">
            <div class="container-fluid">
                <div class="bg-white row pl-3 pr-3 pt-2 pb-2 mb-3">
                    <b> 订单号：{{sprintf("%010d",$order->id)}} </b>
                </div>

                <!-- cause -->
                <div class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>售后理由</b></span>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100">
                            <select id="cause" name="cause" class="w-100 pt-2 pb-2 text-center" required>
                                <option value="退款">退款</option>
                                <option value="退货">退货</option>
                                <option value="其他">其他</option>
                            </select>
                        </div>
                    </div>
                </div>


                <!-- refund  -->
                <div class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>退款金额</b></span>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100">
                            <input class="border-0 w-100" type="number" step="0.01" name="refund" id="refund" placeholder="请输入申请金额" required>
                        </div>
                    </div>
                </div>

                <!-- note -->
                <div class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>退款说明</b></span>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100">
                            <textarea class="border-0 w-100" type="text" name="note" id="note" placeholder="请输入退款说明" required></textarea>
                        </div>
                    </div>
                </div>

                <!-- images -->
                <div class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>图片上传（可上传多张）</b></span>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100">
                            <input type="file" class="border-0 w-100" name="images[]" id="images" multiple required>
                        </div>
                    </div>
                </div>

                <!-- submit -->
                <div class="mb-3">
                    <div class="row">
                        <input type="submit" class="btn btn-danger btn-block pt-2 pb-2" value="发送申请">
                    </div>
                </div>


            </div>
        </form>

    </div>

    @include('home.layouts.bot-nav')
@endsection