<template>
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-2 col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 justify-content-center m-0 p-0"
                 v-for="product in products">
                <div class="card">
                    <div class="img-container w-100" style="height:178px">
                        <div v-if="product.tag_img_url != null" v-for="(tag_img,index) in product.tag_img_url" class="badge-top-right" v-bind:style="'right:'+index*25+'px !important;'">
                            <img v-bind:src="'/daigou'+tag_img" style="'width:25px;height:50px;">
                        </div>
                        <div class="product-img">
                            <img v-on:click="show_product(product.id)" class="mx-auto d-block mt-4 mb-4" style="height:130px; width:130px"
                                 v-bind:src="'/daigou/storage/app/'+product.img_url">
                        </div>

                    </div>


                    <div class="card-body">
                        <div v-on:click="show_product(product.id)" class="text-left" style="height:25px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;font-weight: 500;font-size: 15px">
                            {{product.name}}
                        </div>
                        <div class="small text-muted">{{product.spec}}</div>
                        <div class="mt-2 row" style="font-size:15px">
                            <div class="col-8 pr-0">
                                <div class="product-price text-grey" style="font-size: small;text-decoration: line-through;line-height: 1.3">$<span>{{ product.RRP }}</span> </div>
                                <div class="product-price text-danger float-left">$AUD <span>{{ product.price }}</span> </div>

                            </div>
                            <div class="col-4 pl-1 pr-1">
                                <div class="d-inline add-cart-img float-right text-right"><img v-on:click="add_item_to_cart(product.id,1)"
                                                                                               v-bind:src="'/daigou/storage/app/assets/home_button_addincart_default@2x.png'" style="width:100%;height:auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .img-container{
        position: relative;
    }
    .badge-top-right{
        position: absolute;
        top: 0px;
        right: 0px;
    }

    @media screen and (max-width:400px){
        .product-price{
            font-size: 85%;
        }

        /*.add-cart-img img{
            width: 40px !important;
            height: 24px !important;
        }*/
    }
</style>

<script>
    export default {
        props: ['productsData'],
        data() {
            return {
                products: [],
                product: {
                    id: '',
                    name: '',
                    price: '',
                    weight: '',
                    img_url: ''
                }
            }
        },
        created() {
            this.products = JSON.parse(this.productsData);
        },
        methods: {
            add_item_to_cart(id,quantity) {
                alert("添加至购物车");
                $.ajax({
                    url: 'add_to_cart',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "product_id": id,
                        "quantity": quantity
                    },
                    dataType: 'json',
                    success: function (response) {
                    },
                    error: function (error) {

                    }
                })
            },
            show_product(id) {
                window.location.href = '/daigou/mall/products/' + id;
            }
        }
    }
</script>