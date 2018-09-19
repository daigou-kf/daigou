<template>
    <div id="product-page" class="mb-5 pb-3 mt-3">
        <div class="container-fluid">
            <a v-bind:href="'/daigou/storage/app/'+product.img_url">
                <div class="row bg-white pb-3 mb-3">

                    <img id="product-img" v-bind:src="'/daigou/storage/app/'+product.img_url">

                </div>
            </a>
            <div class="row bg-white pl-3 pt-3 pb-3 mb-3">
                <div class="col-8 p-0 ">
                    <div><span style="font-size:20px">{{product.name}}</span></div>
                    <span class="text-danger" style="font-size:20px">$AUD</span>
                    <span class="text-danger" style="font-size:32px">{{product.price}}</span>
                    <span class="text-grey ml-1" style="font-size:16px;text-decoration: line-through">${{product.RRP}}</span>
                </div>
                <div class="col-1 p-0 border-right">

                </div>
                <div v-on:click="change_like(product.id)" class="col-3 text-center align-self-center">
                    <img class="like-img" v-if="product.like == 0" v-bind:src="'../../storage/app/assets/dislike.png'">
                    <img class="like-img" v-else v-bind:src="'../../storage/app/assets/like.png'">
                    <div class="text-muted small"> 收藏</div>
                </div>
            </div>
            <div v-if="product.expired_date != null" class="row bg-white pl-3 pr-3 pt-2 pb-2 border-bottom">
                <div class="w-100">
                    <span style="color:darkgrey">保质期</span>
                    <span class="float-right"><a>{{product.expired_date}}</a> </span>
                </div>
            </div>
            <div class="row bg-white pl-3 pr-3 pt-2 pb-2 border-bottom">
                <div class="w-100">
                    <span style="color:darkgrey">包裹重量</span>
                    <span class="float-right"> {{product.weight}}g </span>
                </div>
            </div>
            <div class="row bg-white pl-3 pr-3 pt-2 pb-2 border-bottom">
                <div class="w-100">
                    <span style="color:darkgrey">规格</span>
                    <span class="float-right"> {{product.spec}} </span>
                </div>
            </div>
            <div v-on:click="show_category(product.category.id)" class="row bg-white pl-3 pr-3 pt-2 pb-2 border-bottom">
                <div class="w-100">
                    <span style="color:darkgrey">分类</span>
                    <span class="float-right"> <a>{{product.category.name}}</a> </span>
                </div>
            </div>
            <div v-on:click="show_brand(product.brand.id)" class="row bg-white pl-3 pr-3 pt-2 pb-2 border-bottom">
                <div class="w-100">
                    <span style="color:darkgrey">品牌</span>
                    <span class="float-right"><a>{{product.brand.name}}</a> </span>
                </div>
            </div>
            <div v-on:click="show_detail(product.id)" class="row bg-white pl-3 pr-3 pt-2 pb-2 border-bottom">
                <div class="w-100">
                    <span style="color:darkgrey">详情</span>
                    <span class="float-right"> <i class="fas fa-chevron-right"></i> </span>
                </div>
            </div>
            <div v-on:click="show_stock(product.id)" class="row bg-white pl-3 pr-3 pt-2 pb-2 border-bottom mb-3">
                <div class="w-100">
                    <span style="color:darkgrey">库存</span>
                    <span id="stock_num" class="float-right">查看</span>
                </div>
            </div>
            <div class="row">
                <button v-on:click="add_item_to_cart(product.id)" class="btn btn-danger btn-block"
                        style="height:50px">加入购物车
                </button>
            </div>

        </div>
    </div>
</template>

<style>
    #product-img {
        width: 65vw;
        height: 65vw;
        margin: auto;
    }

    .like-img {
        width: 60%;
        height: 60%;
    }

</style>

<script>
    export default {
        props: ['ProductData'],
        data() {
            return {
                product: ''
            }
        },
        created() {
            this.product = JSON.parse(this.ProductData);
        },
        methods: {
            fetch_product(id) {
                $.ajax({
                    url: '../get_product/' + id,
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        console.log(error);
                    }
                }).done(data => {
                    this.product = data;
                });
            },
            change_like(id) {
                $.ajax({
                    url: 'update_like',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "product_id": id
                    },
                    dataType: 'json',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert('收藏商品请先登录');
                    }
                }).done(data => {
                    this.fetch_product(id);
                });
            },
            add_item_to_cart(id, num) {
                alert("添加至购物车");
                $.ajax({
                    url: '../add_to_cart',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "product_id": id
                    },
                    dataType: 'json',
                    success: function (response) {
                    },
                    error: function (error) {
                    }
                })
            },
            show_brand(id) {
                window.location.href = "/daigou/mall/brands/" + id;
            },
            show_category(id) {
                window.location.href = "/daigou/mall/categories/" + id;
            },
            show_detail(id) {
                window.location.href = "/daigou/mall/products/detail/" + id;
            },
            show_stock(id) {
                $('#stock_num').html('正在查询...');
                $.ajax({
                    url: '/daigou/get_inventory_by_id/' + id,
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                    }
                }).done(data => {
                    if(data.message == 'success'){
                        if (data.data < 0) {
                            $('#stock_num').html(0);
                        } else {
                            $('#stock_num').html(data.data);
                        }
                    } else {
                        $('#stock_num').html('数据未知');
                    }
                });
            }
        }
    }
</script>