<div class="text-nav pl-1 pr-1 @if(isset($category)) mt-1 @endif ">
    <a href="{{route('home_home')}}" class="p-1 @if(!isset($category)) current @endif text-dark">综合</a>
    @foreach($categories as $cate)
        <a href="{{route('home_category_show',['id' => $cate->id])}}" class="pl-2 pr-2 pb-1 pt-1 text-dark @if(isset($category) && $category->id == $cate->id) current @endif ">{{$cate->name}}</a>
    @endforeach
</div>