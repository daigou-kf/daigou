@extends('layouts.app')

@section('content')
    <div id="login-page" class="container">

        <div id="login-logo">
            <img class="mx-auto d-block" src="/daigou/storage/app/assets/point_img_logo_default@2x.png">
        </div>

        <div class="container-fluid pl-5 pr-5 mt-5 text-light">
            <h5>重置密码</h5>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{route('password.request')}}">
                @csrf
                <input type="hidden" name="token" value="{{$token}}">
                <div class="container">
                    <div class="row">
                        <input id="phone" type="number"
                               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} mb-2" name="phone"
                               value="{{ old('phone') }}" placeholder="手机号码" required autofocus>
                        @if ($errors->has('phone'))
                            <span class="invalid-feedback">
                                        <strong class="text-warning">{{ $errors->first('phone') }}</strong>
                                    </span>
                        @endif
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} mb-2" name="password" placeholder="输入新密码" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                        <strong class="text-warning">{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="再次输入新密码" name="password_confirmation" required>

                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback">
                                        <strong class="text-warning">{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif


                        <button type="submit" class="btn btn-block btn-outline-light mt-5">重置</button>
                    </div>
                </div>
            </form>
        </div>


    </div>
@endsection
