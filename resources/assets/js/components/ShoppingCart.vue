<template>
    <div class="justify-content-center mb-5 mt-3">
        <div v-if="init==1 && products.length == 0" class="text-center text-danger">
            <div id="gift-coming">
                <img class="mx-auto d-block"
                     v-bind:src="'/daigou/storage/app/assets/cart_img_emptycart_default@2x.png'">
            </div>
            <div id="gift-coming-logo">
                <img class="mx-auto d-block" v-bind:src="'/daigou/storage/app/assets/point_img_logo_default@2x.png'">
            </div>
        </div>
        <div v-else-if="init==1" class="container-fluid">
            <div class="mb-3">
                <div class="text-right">
                    <button v-on:click="clear_cart()" class="btn btn-sm btn-outline-danger"><i
                            class="far fa-trash-alt"></i>
                        清空购物车
                    </button>
                </div>
            </div>
            <div class="cart-main mb-3">
                <div class="row mb-3" v-for="product in products" v-bind:key="product.id"
                     v-bind:id="'product-'+product.id">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <img class="img-thumbnail mx-auto d-block"
                                         v-bind:src="'../storage/app/'+product.img_url">
                                </div>
                                <div class="col-9">

                                    <div class="row">
                                        <div class="col-5">
                                            <div class="mb-1">{{product.name}}</div>
                                            <div class="text-muted small">包裹重量： {{ product.weight }} g</div>
                                            <div class="text-danger">$AUD {{ product.price }}</div>
                                        </div>
                                        <div class="col-7">
                                            <div class="text-center mb-2">库存：<span v-if="stocks[product.id] != -1">{{stocks[product.id]}}</span><span
                                                    v-else>正在查询...</span></div>
                                            <div class="btn-group" role="group" aria-label="Cart Buttons">
                                                <button v-on:click="minus_quantity(product)" type="button"
                                                        class="btn btn-outline-secondary" disabled> -
                                                </button>
                                                <input v-on:change="update_cart(product)" type="number"
                                                       name="cart-num"
                                                       class="btn btn-outline-secondary w-100"
                                                       v-model="product.quantity" disabled>
                                                <button v-on:click="add_quantity(product)" type="button"
                                                        class="btn btn-outline-secondary" disabled> +
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-6 text-left">
                                    <span><a v-on:click="remove_from_cart(product)"><u>删除</u></a></span>
                                </div>
                                <div class="col-6 text-right">
                                    小记：<span
                                        class="text-danger">$AUD {{(product.price * product.quantity).toFixed(2)}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="summary mt-2">

                <div class="row mb-2">
                    <div class="list-group-item w-100 border-0 bg-transparent"><span class="h2">小结</span></div>
                </div>
                <div class="row">
                    <ul class="list-group w-100">
                        <li class="list-group-item">
                            <ul class="list-inline">
                                <li class="list-inline-item float-left">包裹重量</li>
                                <li class="list-inline-item float-right">{{total_weight}}g</li>
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <ul class="list-inline">
                                <li class="list-inline-item float-left">快递费用</li>
                                <li class="list-inline-item float-right">AUD ${{delivery_fee}}</li>
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <ul class="list-inline">
                                <li class="list-inline-item float-left">总数量</li>
                                <li class="list-inline-item float-right">{{total_num}}</li>
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <ul class="list-inline">
                                <li class="list-inline-item align-self-center float-left">总价：<span class="text-danger">AUD $ {{total_price}}</span>
                                    <span class="text-muted small"></span></li>
                                <li class="list-inline-item float-right">
                                    <button id="submit-button" v-on:click="select_package_method()" type="button"
                                            class="btn btn-danger" disabled>提交订单
                                    </button>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        props: ['deliRate'],
        data() {
            return {
                products: [],
                stocks: [],
                init: 0,
                delivery_rate: ''
            }
        },
        computed: {
            total_price: function () {
                let price = 0;
                _.filter(this.products, product => {
                    price = price + parseFloat(product.price * product.quantity);
                });
                price = price + parseFloat(this.delivery_fee);
                price = price.toFixed(2);
                return price;
            },
            total_weight: function () {
                let weight = 0;
                _.filter(this.products, product => {
                    weight = weight + parseInt(product.weight * product.quantity);
                });
                return weight;
            },
            total_num: function () {
                let num = 0;
                _.filter(this.products, product => {
                    num = num + parseInt(product.quantity);
                });
                return num;
            },
            delivery_fee: function () {
                let weight = this.total_weight;
                if (weight <= 1000) {
                    return (1000 * this.delivery_rate).toFixed(2);
                } else {
                    return (weight * this.delivery_rate).toFixed(2);
                }
            }
        },
        created() {
            this.fetchProducts();
            this.delivery_rate = this.$props.deliRate;

        },
        methods: {
            fetchProducts() {
                $.ajax({
                    url: 'get_shopping_cart',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        console.log(error);
                    }
                }).done(data => {
                    this.products = data;
                    _.filter(this.products, product => this.stocks[product.id] = -1);
                    this.check_stock();
                    this.init = 1;

                });
            },
            clear_cart() {
                $.ajax({
                    url: 'clear_cart',
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                    },
                    error: function (error) {
                        console.log(error);
                    }
                }).done(data => {
                    this.fetchProducts();
                });
            },
            add_quantity(product) {
                if (product.quantity == this.stocks[product.id]) {
                    return;
                }
                product.quantity++;
                this.update_cart(product);
            },
            minus_quantity(product) {
                if (product.quantity <= 1) {
                    return;
                }
                product.quantity--;
                this.update_cart(product);
            },
            remove_from_cart(product) {
                $.ajax({
                    url: 'remove_from_cart',
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'product_id': product.id
                    },
                    success: function (response) {
                    },
                    error: function (error) {

                    }
                }).done(data => {
                    this.fetchProducts();
                });
            },
            update_cart(product) {
                if (this.stocks[product.id] == 0) {
                    product.quantity = 0;
                    return;
                }
                if (product.quantity > this.stocks[product.id]) {
                    product.quantity = this.stocks[product.id];
                }
                if (product.quantity < 1) {
                    product.quantity = 1;
                }
                $.ajax({
                    url: 'update_cart',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'product_id': product.id,
                        'quantity': product.quantity
                    },
                    dataType: 'json',
                    success: function (response) {

                    },
                    error: function (error) {

                    }
                });
            },
            select_package_method(){
                window.location.href = 'select_package_method';
            },
            check_stock() {
                var number = this.products.length;
                var index = 0;
                var can_create = 1;
                _.filter(this.products, product => {
                    $.ajax({
                        url: '/daigou/get_inventory_by_id/' + product.id,
                        method: 'GET',
                        success: function (response) {
                        },
                        error: function (error) {
                        }
                    }).done(data => {
                        if (data['message'] == "error") {
                            this.$set(this.stocks, product.id, 0);
                            this.update_cart(product);
                            can_create = 0;
                        } else {
                            if (data['data'] <= 0) {
                                this.$set(this.stocks, product.id, 0);
                                can_create = 0;
                            } else {
                                this.$set(this.stocks, product.id, data['data']);
                            }
                            if (product.quantity > this.stocks[product.id]) {
                                this.update_cart(product);
                            }
                        }
                        index++;
                        if (index == number) {
                            $('.btn-group button').removeAttr('disabled');
                            $('.btn-group input').removeAttr('disabled');
                            if (can_create == 1) {
                                $('#submit-button').removeAttr('disabled');
                            }
                        }
                    });
                });


            }
        }

    }
</script>