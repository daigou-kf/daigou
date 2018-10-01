<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    @guest
        <script src="{{ asset('js/guest.js') }}"></script>
    @endguest
    <script src="{{ asset('js/custom.js') }}"></script>

    @if(isset($param))
    <!-- js for address -->
        <script src="{{asset('js/address.js')}}"></script>
    @endif
    @if(isset($page) && $page == 'home' && isset($welcome))
        <script src="{{asset('js/welcome.js')}}"></script>
    @endif
    @if(isset($page) && $page == 'dashboard' && isset($reminder))
        <script src="{{asset('js/reminder.js')}}"></script>
    @endif
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    @if(isset($page) && $page == 'products')
        <style>
            body {
                background-color: white;
            }
        </style>
    @endif


</head>
<body>
<div id="app">

    @if (auth()->user() && auth()->user()->isAdmin())
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel d-none d-lg-block d-xl-block">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }} 管理员
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li><a class="nav-link" href="{{ route('report_tasks') }}">{{ __('未完成Tasks') }}</a></li>
                        <li><a class="nav-link" href="{{ route('collections.index') }}">{{ __('系列') }}</a></li>
                        <li><a class="nav-link" href="{{ route('brands.index') }}">{{ __('品牌') }}</a></li>
                        <li><a class="nav-link" href="{{ route('categories.index') }}">{{ __('类别') }}</a></li>
                        <li><a class="nav-link" href="{{ route('products.index') }}">{{ __('产品') }}</a></li>
                        <li><a class="nav-link" href="{{ route('users.index') }}">{{ __('用户') }}</a></li>
                        <li><a class="nav-link" href="{{ route('pospal.index') }}">{{ __('银豹功能') }}</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif
    <main>
        @yield('content')
    </main>

</div>
<script src="{{ asset('public/js/app.js') }}"></script>
@if(isset($page) && $page == "tangqi_index")
    <script>
        document.getElementById('testing-page').play();
        document.addEventListener("WeixinJSBridgeReady", function () {
            document.getElementById('testing-page').play();
        }, false);
    </script>
@endif
@if(isset($page) && $page == 'home' && isset($welcome))
    <script>
        load_welcome();
    </script>
@endif
@if(isset($page) && $page == 'dashboard' && isset($reminder))
    <script>
        load_reminder();
    </script>
@endif
</body>
</html>
