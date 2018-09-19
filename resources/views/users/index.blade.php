@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('users.user_tab')
        </div>
    </div>
    <div class="container-fluid">
        @include('layouts.feedback')
        <table class="table table-bordered table-hover text-center">
            <thead>
            <tr>
                <td>
                    <h1>电话</h1>
                </td>
                <td>
                    <h1>级别</h1>
                </td>
                <td>
                    <h1>操作</h1>
                </td>
            </tr>
            </thead>
            @foreach($users as $user)
                @if(!$user->admin && !$user->staff)
                <tr>
                    <td><h1>{{$user['phone']}}</h1></td>
                    <td><h1> @if ($user['admin']) 管理员 @else 普通用户 @endif</h1></td>
                    <td>
                        <div class="btn-group-vertical d-flex">
                            <a href="{{action('UserController@show', $user['id'])}}" class="btn btn-info">查看</a>
                        </div>
                    </td>
                </tr>
                @endif

            @endforeach

        </table>
    </div>
@endsection