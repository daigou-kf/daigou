@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('categories.category_tab')
        </div>
        <hr>
        @include('layouts.feedback')
        <table class="table table-bordered table-hover text-center">
            <thead>
            <tr>
                <td>
                    <h1>ID</h1>
                </td>
                <td>
                    <h1>名称</h1>
                </td>
                <td>
                    <h1>图片</h1>
                </td>
                <td>
                    <h1>操作</h1>
                </td>
            </tr>
            </thead>
            @foreach($categories as $category)
                <tr>
                    <td><h2>{{$category['id']}}</h2></td>
                    <td><h2>{{$category['name']}}</h2></td>
                    <td class="d-flex justify-content-center">@if(isset($category['img_url']))<img src="storage/app/{{$category['img_url']}}"
                                                                   style="width:100px;height:100px">@else 无图片 @endif</td>
                    <td>
                        <div class="btn-group-vertical d-flex">
                            <a href="{{action('CategoryController@show', $category['id'])}}" class="btn btn-info">显示</a>
                            <a href="{{action('CategoryController@edit', $category['id'])}}" class="btn btn-info">编辑</a>
                            <form action="{{action('CategoryController@destroy',$category['id'])}}" class="w-100" method="post">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button onclick="return confirm('确定删除吗？')" type="submit" class="btn btn-danger">删除</button>
                            </form>
                        </div>
                    </td>
                </tr>

            @endforeach

        </table>
    </div>

@endsection
