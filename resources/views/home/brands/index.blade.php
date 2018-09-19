@extends('layouts.app')

@section('content')
    @include('home.layouts.search-bar')
    @include('home.layouts.search-tab')
    <Brands :brands-data="'{{ json_encode($brands) }}'" class="mt-5 mb-3"></Brands>


    @include('home.layouts.bot-nav')
@endsection

