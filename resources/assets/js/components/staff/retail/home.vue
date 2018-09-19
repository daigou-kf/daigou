<template>
    <div>
        <!-- uncompleted orders -->
        <div class="container-fluid text-center p-3 text-blue">
            <h4>待发货订单</h4>
        </div>
        <div class="container-fluid pb-3">
            <table class="table table-borderless bg-white table-shadow">
                <thead class="bg-secondary text-light">
                <th class="pl-4">订单号</th>
                <th class="text-right pr-4">状态</th>
                </thead>
                <template v-for="order in orders">
                    <tr>
                        <td class="pl-4">{{order.id}}</td>
                        <td class="text-right pr-4">
                            <button v-on:click="show_order(order.id)" class="btn btn-secondary p-0">待处理</button>
                        </td>
                    </tr>
                </template>

            </table>
        </div>

        <hr>

        <!-- completed orders -->
        <div class="container-fluid text-center p-3 text-blue">
            <h4>今日已完成订单</h4>
        </div>
        <div class="container-fluid">
            <table class="table table-borderless bg-white table-shadow">
                <thead class="bg-secondary text-light">
                <th class="pl-4">订单号</th>
                <th class="text-right pr-4">状态</th>
                </thead>
                <template v-for="order in completed_orders">
                    <tr>
                        <td class="pl-4">{{order.id}}</td>
                        <td class="text-right pr-4"><button class="btn btn-gold text-white p-0">已处理</button></td>
                    </tr>
                </template>

            </table>
        </div>
        <div class="container-fluid fixed-bottom">
            <div class="row">
                <a href="/daigou/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn-warning btn btn-block text-light">退出</a>
            </div>
        </div>

        <form id="logout-form" action="/daigou/logout" method="POST"
              style="display: none;">
            <input name="_token" type="hidden" v-model="csrf_token">
        </form>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                csrf_token: null,
                orders: [],
                completed_orders: [],
                all_orders: []
            }
        },
        created() {
            this.csrf_token = $('meta[name="csrf-token"]').attr('content');
            this.all_orders = this.$parent.all_orders;
            _.filter(this.all_orders, each_order => {
                if (each_order.status == 1) {
                    this.orders.push(each_order);
                } else if (each_order.status == 2) {
                    this.completed_orders.push(each_order);
                }
            });
        },
        methods: {
            show_order(order_id){
                var order = null;
                _.filter(this.orders, each_order => {
                    if(each_order.id == order_id){
                        order = each_order;
                    }
                });
                this.$router.push({name: 'StaffOrder', params: {id: order_id, order: order}});
            }
        }
    }
</script>