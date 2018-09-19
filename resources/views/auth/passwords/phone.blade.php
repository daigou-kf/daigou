@extends('layouts.app')

@section('content')
    <div id="login-page" class="container">

        <div id="login-logo">
            <img class="mx-auto d-block" src="/daigou/storage/app/assets/point_img_logo_default@2x.png">
        </div>

        <div class="container-fluid pl-5 pr-5 mt-5 text-light">
            <h5>手机号码</h5>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{route('password.email')}}">
                @csrf
                <div class="container">
                    <div class="row">
                        <input id="phone" type="number"
                               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone"
                               value="{{ old('phone') }}" placeholder="填写手机号码" required autofocus>
                        @if ($errors->has('phone'))
                            <span class="invalid-feedback">
                                        <strong class="text-warning">{{ $errors->first('phone') }}</strong>
                                    </span>
                        @endif

                        <button type="submit" class="btn btn-block btn-outline-light mt-5">发送链接</button>
                    </div>
                </div>
            </form>
            <div class="text-center w-100 fixed-bottom pb-3"><a href="{{route('login')}}"
                                                                class="text-light"><u>返回登录界面</u></a></div>
        </div>
    </div>
@endsection
