<template>
    <div id="product-list-page">
        <!-- List of products -->
        <div v-for="product in products">
            <div class="container-fluid">
                <div class="row bg-white p-2">
                    <div class="col-3">
                        <img v-bind:src="'/daigou/storage/app/'+product.img_url" v-on:click="show_product(product.id)" class="img-thumbnail">
                    </div>
                    <div class="col-9 pl-0 pr-0">
                        <div class="align-top">
                            <div v-on:click="show_product(product.id)" class="text-dark mb-1" style="height:1.5em;line-height:1.5em;white-space: nowrap;overflow:hidden;text-overflow: ellipsis"> {{product.name}} </div>
                            <div class="row">
                                <div v-on:click="show_product(product.id)" class="col-8">
                                    <div class="text-muted small">{{product.weight}}g {{product.spec}}</div>
                                    <div class="text-danger"> $<span style="font-size: large">{{product.price}}</span> <span class="text-grey ml-1" style="text-decoration: line-through">${{product.RRP}}</span> </div>
                                </div>
                                <div class="col-4 pl-0 pr-0">
                                    <div class="add-cart-img text-center mt-2"><img v-on:click="add_item_to_cart(product.id,1)"
                                                                                                v-bind:src="'/daigou/storage/app/assets/home_button_addincart_default@2x.png'" style="width:51px;height:31px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="m-0">
            </div>

        </div>
    </div>
</template>

<script>
    export default{
        props: ['productsData'],
        data(){
            return {
                products: []
            }
        },
        created(){
            this.products = JSON.parse(this.productsData);
        },
        methods:{
            add_item_to_cart(id, num) {
                alert("添加至购物车");
                $.ajax({
                    url: '/daigou/mall/update_cart',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "product_id": id,
                        "num": num
                    },
                    dataType: 'json',
                    success: function (response) {
                    },
                    error: function (error) {
                    }
                })
            },
            show_product(id){
                window.location.href = '/daigou/mall/products/'+id;
            }
        }
    }
</script>