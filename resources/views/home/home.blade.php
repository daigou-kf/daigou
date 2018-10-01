@extends('layouts.app')

@section('content')
    @include('home.layouts.search-bar')
    @include('home.layouts.text-nav-bar')
    <div class="banner">
        @component('layouts.image_gallery',['gallery_id' => 'firstshopping-banner',
        'data_array' => [
            [
                'src' => 'assets/home_logo.png',
                'href' => null
            ],
            [
                'src' => 'assets/banner_question.png',
                'href' => route('users.info.questions')
            ]
        ],
        'has_button' => false,
        'width' => '100%'])

        @endcomponent
    </div>

    <div class="container-fluid mt-3 mb-3">
        <div class="row bg-white pb-2">
            @foreach($collections as $collection)
                <div class="col-3 pl-1 pr-1"><a href="{{route('home.collections.show',['id' => $collection->id])}}">

                        <img class="mx-auto d-block mb-1"
                             src="{{asset('storage/app/'.$collection->img_url)}}"
                             style="width:60px;height:60px"></a>
                    <div class="small w-100 text-center text-dark">{{$collection->name}}</div>
                </div>
            @endforeach
        </div>
    </div>


    <Products :products-data="'{{ json_encode($products) }}'" class="mb-3"></Products>

    @include('home.layouts.bot-nav')

    @if(isset($welcome))
        @component('layouts.modal',[
            'modal_id'=>'welcome-message',
            'size'=>'modal-med',
            'title'=>'用户须知',
            'title_size'=>'h3',
            'footer'=>false
        ])
            @slot('content')
                <form method="post" action="{{route('users.disable_welcome')}}">
                    @csrf
                    <div class="w-100 bg-transparent border-0 mt-3 pl-3 pr-3">
                        <p class="text-justify" style="font-size: 16px; font-weight: bold">
                            First Shopping代购商城仅限澳大利亚地区顾客使用，有效地保证澳洲本地顾客的权益。<br><br>
                            会员注册只能使用澳洲本地手机号码，如若造成不便，尽情见谅。
                        </p>
                    </div>
                    <div class="form-control w-100 form-inline bg-transparent border-0 mt-3 pl-3 pr-3">
                        <label><span class="text-muted">不再显示此消息</span>
                            <input type="checkbox" class="mr-2"
                                   name="disable_welcome" style="transform: scale(1.3)">
                            <span class="checkmark"></span>

                        </label>

                    </div>
                    <button type="submit" class="w-100 text-white btn btn-block btn-lg mt-3" style="background-color:#62A2EC">确定</button>
                </form>
            @endslot
        @endcomponent
    @endif
@endsection

