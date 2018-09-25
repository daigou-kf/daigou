<nav class="fixed-bottom container-fluid border-top" >
    <div class="row">
        <div class="btn-group w-100">
                <button class="btn w-100">
                    <a href="{{route('index')}}" class="nav-color @if(isset($page) && $page == "home") text-danger @else text-muted @endif ">
                        @if(isset($page) && $page == "home") <img src="/storage/assets/tabbar_icon_home_selected@2x.png" style="width:24px;height:24px"> @else <img src="/storage/assets/tabbar_icon_home_default@2x.png" style="width:24px;height:24px">@endif
                        <p class="bot-nav">首页</p>
                    </a>
                </button>
                <button class="btn w-100">
                    <a href="{{route('home_products')}}" class="nav-color @if(isset($page) && $page == "products") text-danger @else text-muted @endif">
                        @if(isset($page) && $page == "products") <img src="/storage/assets/tabbar_icon_category_selected@2x.png" style="width:24px;height:24px"> @else <img src="/storage/assets/tabbar_icon_category_default@2x.png" style="width:24px;height:24px">@endif
                        <p class="bot-nav">全部商品</p>
                    </a>
                </button>
                <button class="btn w-100">
                    <a href="{{route('home_gift_center')}}" class="nav-color @if(isset($page) && $page == "gift_center") text-danger @else text-muted @endif">
                        @if(isset($page) && $page == "gift_center") <img src="/storage/assets/tabbar_icon_point_selected@2x.png" style="width:24px;height:24px"> @else <img src="/storage/assets/tabbar_icon_point_default@2x.png" style="width:24px;height:24px">@endif
                        <p class="bot-nav">积分商城</p>
                    </a>
                </button>
                <button class="btn w-100">
                    <a href="{{route('home_cart')}}" class="nav-color @if(isset($page) && $page == "shopping_cart") text-danger @else text-muted @endif">
                        @if(isset($page) && $page == "shopping_cart") <img src="/storage/assets/tabbar_icon_cart_selected@2x.png" style="width:24px;height:24px"> @else <img src="/storage/assets/tabbar_icon_cart_default@2x.png" style="width:24px;height:24px">@endif
                        <p class="bot-nav">购物车</p>
                    </a>
                </button>
                <button class="btn w-100">
                    <a href="{{route('home_dashboard')}}" class="nav-color @if(isset($page) && $page == "dashboard") text-danger @else text-muted @endif">
                        @if(isset($page) && $page == "dashboard") <img src="/storage/assets/tabbar_icon_me_selected@2x.png" style="width:24px;height:24px"> @else <img src="/storage/assets/tabbar_icon_me_default@2x.png" style="width:24px;height:24px">@endif
                        <p class="bot-nav">个人中心</p>
                    </a>
                </button>
        </div>
    </div>
</nav>