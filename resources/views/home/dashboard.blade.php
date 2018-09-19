@extends('layouts.app')

@section('content')
    <div class="container-fluid mb-3 p-0">
        <div class="card pt-5 profile-bg pb-3">
            <img class="card-img-top w-25 m-auto" src="/daigou/storage/app/assets/blank-profile-pic.png">
            @auth
                <h5 class="card-title text-center text-light small mt-1">
                    余额: {{ number_format(Auth::user()->balance,2,'.','') }}
                </h5>
            @else
                <div class="mt-3">

                </div>
            @endauth
        </div>
    </div>
    @include('layouts.feedback')
    <div class="container-fluid mb-5 pb-3">
        <div class="row">
            <div class="list-group w-100">
                <a href="{{route('home_address_index')}}"
                   class="list-group-item list-group-item-action btn pt-2 pb-2"><img style="width:40px;height:40px"
                                                                                     src="/daigou/storage/app/assets/me_icon_address_default@2x.png">
                    编辑地址
                    <div class="float-right"><img style="height:40px;width:40px"
                                                  src="/daigou/storage/app/assets/me_icon_nextpage_default@2x.png">
                    </div>
                </a>
                <a href="{{route('home_order_index')}}"
                   class="list-group-item list-group-item-action btn pt-2 pb-2"><img style="width:40px;height:40px"
                                                                                     src="/daigou/storage/app/assets/me_icon_myorder_default@2x.png">我的订单
                    <div class="float-right"><img style="height:40px;width:40px"
                                                  src="/daigou/storage/app/assets/me_icon_nextpage_default@2x.png">
                    </div>
                </a>
                <a href="{{route('home_gift_center')}}"
                   class="list-group-item list-group-item-action btn pt-2 pb-2"><img style="width:40px;height:40px"
                                                                                     src="/daigou/storage/app/assets/me_icon_mypoint_default@2x.png">我的积分
                    <div class="float-right"><img style="height:40px;width:40px"
                                                  src="/daigou/storage/app/assets/me_icon_nextpage_default@2x.png">
                    </div>
                </a>
                <a href="{{route('home_favourite_index')}}"
                   class="list-group-item list-group-item-action btn pt-2 pb-2"><img style="width:40px;height:40px"
                                                                                     src="/daigou/storage/app/assets/me_icon_collection_default@2x.png">商品收藏
                    <div class="float-right"><img style="height:40px;width:40px"
                                                  src="/daigou/storage/app/assets/me_icon_nextpage_default@2x.png">
                    </div>
                </a>
                <a href="{{route('home_edit_password')}}"
                   class="list-group-item list-group-item-action btn pt-2 pb-2"><img style="width:40px;height:40px"
                                                                                     src="/daigou/storage/app/assets/me_icon_editinformation_default@2x.png">修改信息
                    <div class="float-right"><img style="height:40px;width:40px"
                                                  src="/daigou/storage/app/assets/me_icon_nextpage_default@2x.png">
                    </div>
                </a>
                <a href="{{route('home_service_index')}}"
                   class="list-group-item list-group-item-action btn pt-2 pb-2"><img style="width:40px;height:40px"
                                                                                     src="/daigou/storage/app/assets/me_icon_aftersale_default@2x.png">售后列表
                    <div class="float-right"><img style="height:40px;width:40px"
                                                  src="/daigou/storage/app/assets/me_icon_nextpage_default@2x.png">
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="list-group w-100">
                <a href="{{route('users.info.questions')}}"
                   class="list-group-item list-group-item-action btn pt-2 pb-2"><img class="p-1"
                                                                                     style="width:40px;height:40px"
                                                                                     src="/daigou/storage/app/assets/question.png">常见问题
                    <div class="float-right"><img style="height:40px;width:40px"
                                                  src="/daigou/storage/app/assets/me_icon_nextpage_default@2x.png">
                    </div>
                </a>
                <a href="{{route('users.info.contact_us')}}"
                   class="list-group-item list-group-item-action btn pt-2 pb-2"><img class="p-1"
                                                                                     style="width:40px;height:40px"
                                                                                     src="/daigou/storage/app/assets/contact_us.png">联系我们
                    <div class="float-right"><img style="height:40px;width:40px"
                                                  src="/daigou/storage/app/assets/me_icon_nextpage_default@2x.png">
                    </div>
                </a>
                <a href="{{route('users.info.about_us')}}" class="list-group-item list-group-item-action btn pt-2 pb-2"><img
                            class="p-1" style="width:40px;height:40px"
                            src="/daigou/storage/app/assets/about_us.png">关于我们
                    <div class="float-right"><img style="height:40px;width:40px"
                                                  src="/daigou/storage/app/assets/me_icon_nextpage_default@2x.png">
                    </div>
                </a>

            </div>
        </div>
        @auth
        <div class="mt-3">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
               {{ __('Logout') }} class="btn-danger btn-block btn">退出</a>
        </div>
        @else
            <div class="mt-3">
                <a href="{{ route('login') }}" class="btn-success btn-block btn">登录</a>
            </div>
        @endauth
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST"
          style="display: none;">
        @csrf
    </form>
    @include('home.layouts.bot-nav')
@endsection


