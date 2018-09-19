@extends('layouts.app')

@section('content')
    <h3 class="text-center mt-3"> {{$collection->name}}</h3>
    <Products :products-data="'{{ json_encode($products) }}'"></Products>

    @include('home.layouts.bot-nav')
@endsection