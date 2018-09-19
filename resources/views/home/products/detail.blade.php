@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-3 mb-3">
        <p>
            {{$product->description}}
        </p>
    </div>
    <div class="container-fluid">
        <a href="{{route('home_product_show',['id' => $product->id])}}" class="btn btn-block btn-secondary">返回产品</a>
    </div>

    @include('home.layouts.bot-nav')
@endsection