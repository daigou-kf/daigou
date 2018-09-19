@extends('layouts.app')

@section('content')
    <div id="login-page" class="container">
        <div id="login-logo">
            <img class="mx-auto d-block" src="/daigou/storage/app/assets/point_img_logo_default@2x.png">
        </div>
        <div id="form-section" class="container-fluid pl-c5 pr-c5 mt-5 text-light">
            <h5>会员登录</h5>

            <form method="POST" action="{{route('login')}}">
                @csrf
                <div class="container">
                    <div class="row">
                        <input id="phone" type="number"
                               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone"
                               value="{{ old('phone') }}" placeholder="手机号码" required autofocus>
                        @if ($errors->has('phone'))
                            <span class="invalid-feedback">
                                        <strong class="text-warning">{{ $errors->first('phone') }}</strong>
                                    </span>
                        @endif
                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               placeholder="输入密码" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                        <strong class="text-warning">{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <div class="form-control w-100 form-inline bg-transparent border-0 mt-3 text-light">
                            <a href="{{ route('password.request') }}" class="text-light pr-4">忘记密码？</a>
                            <span class="d-inline float-right"><input type="checkbox"
                                                                     name="remember" checked {{old('remember') ? 'checked' : ''}}>自动登录
                            </span>

                        </div>
                        <button type="submit" class="btn btn-block btn-outline-light mt-5">登录</button>
                    </div>
                </div>
            </form>

            <div class="text-center w-100 fixed-bottom pb-3">您是新用户？<a href="{{route('register')}}"
                                                                      class="text-light"><u>免费注册</u></a></div>
        </div>


    </div>
@endsection
