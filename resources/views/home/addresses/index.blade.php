@extends('layouts.app')

@section('content')
    <Addresses>
        <button onclick="window.history.back();" class="btn btn-block btn-secondary">返回</button>
    </Addresses>

    @include('home.layouts.bot-nav')
@endsection

