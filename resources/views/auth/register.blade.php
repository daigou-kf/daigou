@extends('layouts.app')

@section('content')
    <div id="login-page" class="container">

        <div id="login-logo">
            <img class="mx-auto d-block" src="/daigou/storage/app/assets/point_img_logo_default@2x.png">
        </div>

        <div class="container-fluid pl-c5 pr-c5 mt-5 text-light">
            <h5>免费注册</h5>
            <form id="register_form" method="POST" action="{{route('register')}}">
                @csrf
                <div class="container">
                    <div class="row">

                        <input id="phone" type="number"
                               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} mb-1"
                               name="phone" value="{{ old('phone') }}" placeholder="手机号码" required>
                        <span class="w-100 small text-center text-light mb-1">仅限澳大利亚手机号码 如：04********</span>

                        @if ($errors->has('phone'))
                            <span class="invalid-feedback">
                                        <strong class="text-warning">{{ $errors->first('phone') }}</strong>
                                    </span>
                        @endif

                        <div class="form-inline w-100 mb-2">
                            <div class="col-6 p-0">
                                <input id="code" type="number"
                                       class="form-control d-inline"
                                       name="code" placeholder="手机验证码" required>

                            </div>
                            <div class="col-6 p-0">
                                <button id="code_button" onclick="get_code()" type="button" class="d-inline w-100 btn btn-secondary">
                                    获取验证码
                                </button>
                            </div>

                        </div>

                        @if ($errors->has('code'))
                            <div class="d-block invalid-feedback">
                                <strong class="text-warning">{{ $errors->first('code') }}</strong>
                            </div>
                        @endif

                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} mb-2"
                               name="password" placeholder="输入密码" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                        <strong class="text-warning">{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif

                        <input id="password-confirm" type="password" class="form-control mb-2"
                               name="password_confirmation" placeholder="再次输入密码" required>

                        <button type="submit" class="btn btn-block btn-outline-light">注册</button>
                    </div>
                </div>
            </form>

            <div class="text-center w-100 fixed-bottom pb-3"><a href="{{route('login')}}"
                                                                class="text-light"><u>返回登录界面</u></a></div>
        </div>


    </div>

@endsection
