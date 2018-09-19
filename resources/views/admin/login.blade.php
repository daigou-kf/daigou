@extends('layouts.app')

<style>
    #admin-login-page #login-form {
        position: fixed;
        top: 20vh;
    }

    #login-form .input-group,button[type='submit'] {
        height: 50px;
        width: 60vw;
    }

    #login-form .input-group input{
        border-radius: 1.2rem;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        opacity: 0.8;
    }

    #login-form .input-group span.input-group-text{
        border-radius: 1.2rem;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        opacity: 0.8;
    }

    #login-form form input {
        background-color: #e9ecef;
    }

    #login-form form button[type='submit']{
        margin-top: 20vh;
    }


</style>

@section('content')
    <div id="admin-login-page">

        <div id="login-form" class="container-fluid pl-5 pr-5 text-light pt-5">

            <form method="POST" action="{{route('login')}}">
                @csrf
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="input-group input-group-lg mb-3">
                            <input id="phone" type="text"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} border-0" name="phone"
                                   value="{{ old('phone') }}" placeholder="username" required autofocus>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} border-0"
                                   placeholder="passowrd" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-block btn-gold text-white">LOGIN</button>
                    </div>
                </div>
            </form>
        </div>


    </div>
@endsection
