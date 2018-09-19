@extends('layouts.app')

@section('content')
    @include('home.layouts.search-bar')
    @include('home.layouts.search-tab')
    <products-list :products-data="'{{ json_encode($products) }}'" class="mb-5 pb-3"></products-list>
    @include('home.layouts.bot-nav')
@endsection