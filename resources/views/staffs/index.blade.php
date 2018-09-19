@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('users.user_tab')
        </div>
    </div>
    @include('layouts.feedback')
    <div class="container-fluid">
        <table class="table table-bordered table-hover text-center">
            <thead>
            <tr>
                <td>
                    <h1>用户名</h1>
                </td>
                <td>
                    <h1>职务</h1>
                </td>
                <td>
                    <h1>操作</h1>
                </td>
            </tr>
            </thead>
            @foreach($admins as $user)
                <tr>
                    <td><h1>{{$user['phone']}}</h1></td>
                    <td><h1>管理员</h1></td>
                    <td>
                        <div class="btn-group-vertical d-flex">
                            <a href="{{action('UserController@show', $user['id'])}}" class="btn btn-info">查看</a>
                        </div>
                    </td>
                </tr>

            @endforeach
            @foreach($staffs as $user)
                    <tr>
                        <td><h1>{{$user['phone']}}</h1></td>
                        <td><h1> @if ($user->staff == 1) 店员 @elseif($user->staff == 2) 财务 @endif</h1></td>
                        <td>
                            <div class="btn-group-vertical d-flex">
                                <a href="{{action('UserController@show', $user['id'])}}" class="btn btn-info">查看</a>
                            </div>
                        </td>
                    </tr>

            @endforeach

        </table>
    </div>
@endsection