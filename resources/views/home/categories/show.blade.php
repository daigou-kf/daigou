@extends('layouts.app')

@section('content')
    @include('home.layouts.text-nav-bar')
    <h3 class="text-center mt-3"> {{$category->name}}</h3>
    <Products :products-data="'{{$category['products']}}'"></Products>

    @include('home.layouts.bot-nav')
@endsection