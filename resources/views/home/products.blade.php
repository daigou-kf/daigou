@extends('layouts.app')

@section('content')
    @include('home.layouts.search-bar')
    @include('home.layouts.search-tab')
    <Categories :categories-data="'{{ json_encode($categories) }}'" class="mt-5 mb-3"></Categories>


    @include('home.layouts.bot-nav')
@endsection

