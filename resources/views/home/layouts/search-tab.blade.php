<div class="container-fluid" id="search-tab">
    <div class="row" style="background-color: white">
        <ul class="nav nav-pills w-100 text-center" id="pills-tab" role="tablist">
            <li class="nav-item w-25">
                <a class="nav-link text-danger font-weight-bold @if(isset($type) && $type == 'brand') active @endif"
                   href="{{route('home_brands')}}">品牌</a>
            </li>
            <li class="nav-item w-25">
                <a class="nav-link text-danger font-weight-bold @if(isset($type) && $type == 'category') active @endif"
                   href="{{route('home_products')}}">类别</a>
            </li>
            <li class="nav-item w-25">
                <a @if(isset($search_query) && $search_query == "price_up")onclick="event.preventDefault();document.getElementById('search-form-price-down').submit();"  @else onclick="event.preventDefault();document.getElementById('search-form-price-up').submit();" @endif class="nav-link text-danger font-weight-bold @if(isset($search_query) && ($search_query == 'price_up' || $search_query == 'price_down')) active @endif ">价格@if(isset($search_query) && $search_query == "price_down")
                        <i class="fas fa-long-arrow-alt-down"></i> @elseif(isset($search_query) && $search_query == "price_up")
                        <i class="fas fa-long-arrow-alt-up"></i> @endif </a>
            </li>
            <li class="nav-item w-25">
                <a onclick="event.preventDefault(); document.getElementById('search-form').submit();"
                   class="nav-link text-danger font-weight-bold @if(isset($search_query) && $search_query == 'sale_down')active @endif "> 销量 @if(isset($search_query) && $search_query == 'sale_down') <i class="fas fa-long-arrow-alt-down"></i> @endif </a>
            </li>
        </ul>
    </div>
</div>

<form id="search-form" action="{{route('home_search_products')}}" method="post" class="d-none">
    @csrf
    <input name="search_query" type="hidden" value="sale_down">
</form>
<form id="search-form-price-up" action="{{route('home_search_products')}}" method="post" class="d-none">
    @csrf
    <input name="search_query" type="hidden" value="price_up">
</form>
<form id="search-form-price-down" action="{{route('home_search_products')}}" method="post" class="d-none">
    @csrf
    <input name="search_query" type="hidden" value="price_down">
</form>
