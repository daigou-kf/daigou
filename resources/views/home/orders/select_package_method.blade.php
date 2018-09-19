@extends('layouts.app')

<style>
    .new-btn{
        position: fixed;
        left: 50vw;
        top: 45vh;
        transform: translateX(-50%) translateY(-50%);
    }

    .old-btn{
        position: fixed;
        left: 50vw;
        top: 55vh;
        transform: translateX(-50%) translateY(+50%);
    }
</style>

@section('content')
    <form class="custom-form" method="post" action="{{route('home_create_order')}}">
        @csrf
        <input type="hidden" name="package_method" value="auto">
        <button type="submit" class="custom-btn new-btn btn btn-danger">我是新手<span class="small">(店员分拣)</span></button>
    </form>
    <form class="custom-form" method="post" action="{{route('home_create_order')}}">
        @csrf
        <input type="hidden" name="package_method" value="self">
        <button type="submit" class="custom-btn old-btn btn btn-danger" disabled>代购老鸟<span class="small">(自己分拣,coming soon)</span></button>
    </form>
    @include('home.layouts.bot-nav')
@endsection