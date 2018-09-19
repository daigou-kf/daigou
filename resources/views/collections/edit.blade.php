@extends('layouts.app')

@section('content')
    <div class="container">
        @include('collections.collection_tab')
        <div class="container-fluid">
            @include('collections.form',['action' => 'edit'])
        </div>
    </div>


@endsection
