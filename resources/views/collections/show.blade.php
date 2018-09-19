@extends('layouts.app')

@section('content')
    <div class="container">
        @include('collections.collection_tab')
        @include('layouts.feedback')
        <h3>{{$collection->name}}</h3>
        @if($collection->search_name != 'hot' && $collection->search_name != 'new')
            <div class="container">
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#add-product"> 添加产品
                </button>
            </div>

            <div class="modal fade" id="add-product" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">选择产品</h3>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('collections.update_products',['id'=>$collection->id])}}">
                                @csrf
                                @component('layouts.table',['key_array'=>['name','price','img_url','category_id','brand_id'],'key_name'=>['名称','价格','图片','类别','品牌','操作'],'data_array'=>$all_products,'check'=>'true','check_type'=>'collection','collection'=>$collection])

                                @endcomponent
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @component('layouts.table',['key_array' => ['id','name','price','img_url','sale','category_id','brand_id'],'key_name' =>
        ['ID','名称','价格','图片','销量','类别','品牌','操作'], 'data_array' => $products])
        @endcomponent
    </div>

@endsection
