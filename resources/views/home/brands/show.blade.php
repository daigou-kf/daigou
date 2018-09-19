@extends('layouts.app')

@section('content')
    <h3 class="text-center"> {{$brand->name}}</h3>
    <Products :products-data="'{{$brand['products']}}'"></Products>

    @include('home.layouts.bot-nav')
@endsection