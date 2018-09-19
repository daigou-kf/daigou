@extends('layouts.app')

@section('content')
    <Product :product-data="'{{ json_encode($product) }}'"></Product>

    @include('home.layouts.bot-nav')
@endsection