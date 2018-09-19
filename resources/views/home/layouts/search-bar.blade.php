<form action="{{route('home_search_products')}}" method="post" class="form-inline bg-white">
    @csrf
    <div class="container-fluid">
        <div class="row" style="height:37px">

                <div class="form-group w-100 mb-2">
                    <input name="search_query" type="text" class="text-left form-control" placeholder="&#xf002; 搜索商品" style="font-family: FontAwesome;">
                </div>
        </div>
    </div>
</form>
