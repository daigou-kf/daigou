@extends('layouts.app')

@section('content')
    <shopping-cart :deli-rate="'{{$rate}}'" ></shopping-cart>
    @include('home.layouts.bot-nav')
@endsection

