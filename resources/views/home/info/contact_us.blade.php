@extends('layouts.app')

@section('content')
    <div class="container-fluid mb-5 pb-3">
        <h4 class="pl-3 pt-2 pb-1">联系我们</h4>
        @include('layouts.feedback')
        <div class="mt-2 ml-2 mr-2 mb-3 ">
            修改地址请联系线上客服（扫描下方二维码）。如果，产品已清关完毕，进入国内派送阶段，则无法确定地址更改一定成功，望悉知。
        </div>
        <div class="row mb-3" style="margin-left:0.5%" >
            <div class="col-5 ml-3" >
                <img class="w-100" src="{{asset('public/assets/CV_1.png')}}">
            </div>
            <div class="col-5">
                <img class="w-100" src="{{asset('public/assets/CV_2.png')}}">
            </div>
        </div>

        <div class="mt-2 ml-2 mr-2 mb-3 ">
            First Shopping壹商店</br>
            Service Hotline：+61 03 9543 4555 (10:00-18:00）</br>
            Email：admin@tangqi.com.au</br>
        </div>

        <div class="mt-2 ml-2 mr-2 mb-3 ">
            Store Address：</br>
            Box Hill（旗舰店）:</br>
            609-611 Station Street，Box Hill VIC 3128</br>

            BOX Hill（新店）:</br>
            902-904 Whitehorse Road，Box Hill VIC 3128</br>

            Carnegie（门店）：</br>
            135A Koornang Road， Carnegie VIC 3163</br>

            Clayton（仓库/展厅）</br>
            22 Winterton Road，Clayton VIC 3168</br>

        </div>


    </div>

    </div>

    @include('home.layouts.bot-nav')

@endsection


