@extends('layouts.app')

@section('content')
    <div class="container">
        @include('collections.collection_tab')
        @include('layouts.feedback')

        @component('layouts.table',['key_array' => ['name','search_name','img_url','display'],'key_name' =>
        ['名称','搜索名称（英文，后台使用）','图片','首页显示','操作'],'data_array' => $collections, 'edit_link' => 'collections.edit', 'show_link' => 'collections.show'])
        @endcomponent
    </div>

@endsection
