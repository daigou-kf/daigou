@extends ('layouts.app')

@section('content')
    <div class="container-vw-76 mt-vh-30 ml-vw-12 mr-vw-12">
        <form action="{{route('home_change_password')}}" method="post">
            @csrf
            <h5 class="mb-3"><b>修改信息</b> </h5>
            @if ($errors->has('password'))
                <div class="container">
                    <div class="row form-control mb-3 w-100">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                </div>
            @endif
            <input type="password" class="form-control mb-3" placeholder="旧密码" required name="old_password">
            <input type="password" class="form-control mb-3" placeholder="新密码" required name="password">

            <input type="password" class="form-control mb-3" placeholder="确认新密码" required name="password_confirmation">
            <button class="btn w-100 btn-danger" type="submit">更新</button>


        </form>
    </div>

    @include('home.layouts.bot-nav')
@endsection