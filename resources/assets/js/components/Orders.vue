<template>
    <div id="orders-index-page" class="mb-5 pb-3">
        <!-- Tabs -->
        <div class="container-fluid mb-2">
            <div class="row">
                <div class="btn-group w-100" role="group" aria-label="order button group">
                    <button v-on:click="fetch_all_orders" type="button" class="btn btn-outline-danger w-100">全部订单</button>
                    <button v-on:click="fetch_unpaid_orders" type="button" class="btn btn-outline-danger w-100">未支付</button>
                    <button v-on:click="fetch_paid_orders" type="button" class="btn btn-outline-danger w-100">已支付</button>
                    <button v-on:click="fetch_sending_orders" type="button" class="btn btn-outline-danger w-100">已发货</button>
                    <button v-on:click="fetch_completed_orders" type="button" class="btn btn-outline-danger w-100">已完成</button>
                </div>
            </div>
        </div>

        <!-- List of Orders -->
        <div class="container-fluid">
            <div class="row">
                <div class="list-group w-100">
                    <div v-for="order in orders" v-on:click="to_order(order.id)" class="list-group-item mb-2">
                        <h5> 订单号: {{ ("000000000" + order.id).slice(-9) }}
                            <span v-if="order.status == 0" class="text-danger small">（未支付）</span>
                            <span v-if="order.status == 1" class="text-info small">（已支付）</span>
                            <span v-if="order.status == 2" class="text-primary small">（已发货）</span>
                            <span v-if="order.status == 3" class="text-success small">（已完成）</span>
                        </h5>
                        <hr>
                        <div v-for="product in order.products" class="mb-3 container-fluid">
                            <div class="row">
                                <div class="col-3 p-0">
                                    <img v-bind:src="'../storage/app/'+product.img_url" style="width:80px;height:80px" class="mr-2" >
                                </div>
                                <div class="col-9 pl-2">
                                    <div>
                                        {{product.name}}
                                    </div>
                                    <div>
                                        购买数量：{{product.num}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="order.sending_address == null || order.sender_address == null" class="text-center" >
                            <hr>
                            请补充收件人/发件人信息 <span class="float-right"> <i class="fas fa-chevron-right"></i> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
button:focus {
    background-color:#a02e2a !important;
    color: white !important;
    border-color: transparent !important;
    outline: 0 !important;
    box-shadow: none !important;
}

</style>

<script>
    export default {
        data() {
            return {
                orders: []
            }
        },
        created(){
            this.fetch_all_orders();
        },
        methods: {
            fetch_all_orders(){
                $.ajax({
                    url: 'get_all_orders',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.orders = data;
                });
            },
            fetch_unpaid_orders(){
                $.ajax({
                    url: 'get_unpaid_orders',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.orders = data;
                });
            },
            fetch_paid_orders(){
                $.ajax({
                    url: 'get_paid_orders',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.orders = data;
                });
            },
            fetch_sending_orders(){
                $.ajax({
                    url: 'get_sending_orders',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.orders = data;
                });
            },
            fetch_completed_orders(){
                $.ajax({
                    url: 'get_completed_orders',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.orders = data;
                });
            },
            to_order(id){
                window.location.href = "show_order/"+id;
            }
        }
    }
</script>