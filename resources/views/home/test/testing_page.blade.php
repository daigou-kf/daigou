@extends('layouts.app')

@section('content')
    <div id="testing-section" class="container-fluid pl-5 pr-5 mt-3 text-light" style="z-index: 10">

        <button onclick="window.location.href='http://tuangou.tangqi.com.au';" type="submit" class="text-gold btn btn-block btn-outline-light mt-3">团多多</button>

        <button onclick="window.location.href='https://www.tangqi.com.au/daigou';" type="submit" class="text-gold btn btn-block btn-outline-light mt-3">代购商城</button>

        <button onclick="window.location.href='https://www.tangqi.com.au/daigou/others/coming_soon';" class="text-gold btn btn-block btn-outline-light mt-3">亚洲食品</button>

        <button onclick="window.location.href='https://www.tangqi.com.au/daigou/others/coming_soon';" class="text-gold btn btn-block btn-outline-light mt-3">家具商城</button>

    </div>

    <video autoplay muted loop id="testing-page" playsinline>
        <source src="/daigou/storage/app/assets/home-bg.mp4" type="video/mp4">
    </video>


@endsection
