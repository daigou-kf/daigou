@extends('layouts.app')

@section('content')
    <div class="container-fluid mb-5 mt-5">
        <div class="row text-center">
            <h3>{{$message}}</h3>
        </div>
    </div>
    @if(isset($login))
        @include('home.layouts.bot-nav')
    @endif

@endsection