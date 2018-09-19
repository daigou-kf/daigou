@extends('layouts.app')

@section('content')
    @include('brands.brand_tab')

    <div class="container-fluid">
        <table class="table table-hover table-bordered text-center">
            <thead>
            <th>排序</th>
            <th>名称</th>
            <th>图片</th>
            <th>更改为</th>
            </thead>
            <tbody>
            @foreach(range(1,9) as $index )


                <tr>


                    <td>{{$index}}</td>
                    @if($top_ten[$index] != "")
                        <td> {{$top_ten[$index]->name}} </td>
                        <td> @if($top_ten[$index]->img_url) <a
                                    href="{{'/daigou/storage/app/'.$top_ten[$index]->img_url}}" target="_blank"><img
                                        src="{{'/daigou/storage/app/'.$top_ten[$index]->img_url}}"
                                        style="height:100px;width:100px"></a>  @endif </td>
                    @else
                        <td></td>
                        <td></td>
                    @endif

                    <td>
                        <form method="post" action="{{route('change_brand_order')}}" class="form-inline">
                            @csrf
                            <input type="hidden" name="index" value="{{$index}}">
                            <div class="form-group w-75">
                                <select name="brand_id" class="custom-select" required autofocus>
                                    <option disabled selected value="">选择品牌</option>
                                    <option value="-1">从首页删除</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">更新</button>
                        </form>
                    </td>

                </tr>

            @endforeach
            </tbody>

        </table>

    </div>
@endsection