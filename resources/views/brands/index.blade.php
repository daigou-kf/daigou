@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('brands.brand_tab')
        </div>
        <hr>
        @include('layouts.feedback')
        <table class="table table-bordered table-hover text-center">
            <thead>
            <tr>
                <td>
                    <a href="{{route('brands.index')}}" class="text-dark"><h1>ID</h1></a>
                </td>
                <td>
                    <a href="{{route('brands.sort',['order'=>'name'])}}" class="text-dark"><h1>名称</h1></a>
                </td>
                <td>
                    <h1>图片</h1>
                </td>
                <td>
                    <h1>操作</h1>
                </td>
            </tr>
            </thead>
            @foreach($brands as $brand)
                <tr>
                    <td><h2>{{$brand['id']}}</h2></td>
                    <td><h2>{{$brand['name']}}</h2></td>
                    <td class="d-flex justify-content-center">@if(isset($brand['img_url']))<a href="/daigou/storage/app/{{$brand['img_url']}}" target="_blank"><img  src="/daigou/storage/app/{{$brand['img_url']}}"
                                                                   style="width:100px;height:100px" alt="未能加载图片"></a>@else 无图片 @endif</td>
                    <td>
                        <div class="btn-group-vertical d-flex">
                            <a href="{{action('BrandController@show', $brand['id'])}}" class="btn btn-info">显示</a>
                            <a href="{{action('BrandController@edit', $brand['id'])}}" class="btn btn-info">编辑</a>
                            <form action="{{action('BrandController@destroy',$brand['id'])}}" class="w-100" method="post">
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
