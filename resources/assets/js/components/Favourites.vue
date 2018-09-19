<template>
    <div id="favourite-page" class="mb-5">
        <div class="container-fluid mt-3">
            <div v-for="product in fav_products" class="row bg-white pt-2 pb-2 mb-3">
                <div class="col-3">
                    <img v-bind:src="'../storage/app/'+product.img_url" class="img-thumbnail">
                </div>
                <div v-on:click="show_product(product.id)" class="col-5 pl-0">
                    <div class="align-top">
                        <div> {{product.name}}</div>
                        <div class="text-muted small">重量：{{product.weight}}g</div>
                        <div class="text-danger"> $AUD {{product.price}}</div>
                    </div>
                </div>
                <div class="col-1 p-0 border-right">

                </div>
                <div v-on:click="change_like(product.id)" class="col-3 text-center align-self-center">
                    <img class="like-img" v-bind:src="'/daigou/storage/app/assets/like.png'">
                    <div class="text-muted small"> 取消收藏</div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .like-img{
        width: 60%;
        height:60%;
    }
</style>

<script>
    export default {
        data(){
            return{
                'fav_products': ''
            }
        },
        created(){
            this.fetch_fav_products();
        },
        methods: {
            fetch_fav_products(){
                $.ajax({
                    url: 'get_fav',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        console.log(error);
                    }
                }).done(data => {
                    this.fav_products = data;
                });
            },
            change_like(id){
                $.ajax({
                    url: 'products/update_like',
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
                }).done(data => {
                    this.fetch_fav_products();
                });
            },
            show_product(id){
                window.location.href = 'products/'+id;
            }
        }
    }
</script>