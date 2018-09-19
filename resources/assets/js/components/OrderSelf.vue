<template>
    <div>
        <div class="container-fluid mt-3" style="margin-bottom: 80px;">
            <div>
                <h5><b>订单号：{{("000000000" + order.id).slice(-9)}}</b></h5>
            </div>

            <!-- Sender Address -->
            <div id="sender-address" class="mt-3 mb-3">
                <div class="mb-2">
                    <span class="text-left"><b>发件人</b> </span>
                    <span v-on:click="to_addresses" class="float-right text-danger"><i class="fas fa-user-plus"></i> <a><u>新增发件人</u></a> </span>
                </div>
                <div class="bg-white text-center row">
                    <select v-model="order_info.sender_address"
                            class="minimal w-100 pt-2 pb-2 text-center" required>
                        <option v-for="sender_address in order.sender_addresses" v-bind:value="sender_address">
                            {{sender_address.name}}, {{sender_address.phone}}
                        </option>
                    </select>
                </div>
                <div v-if="order_info.sender_address != null"
                     class="text-center text-muted pt-2 pb-2">
                    详细地址：{{order_info.sender_address.detail}}
                </div>
            </div>

            <!-- Payment method -->
            <div id="payment-method" class="mb-3">
                <div class="mb-2">
                    <span class="text-left"><b>支付方式</b></span>
                </div>
                <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                    <div class="w-100">
                        <span class="text-left">微信支付</span>
                        <span><i class="fas fa-check float-right text-danger" style="font-size:20px"></i></span>
                    </div>
                </div>
            </div>

            <!-- Addons -->
            <div id="addons" class="mb-3">
                <div class="mb-2">
                    <span class="text-left"><b>增值服务（AUD $1）</b></span>
                </div>
                <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                    <div class="w-100">
                        <input v-model="order_info.addon" name="addon" type="checkbox">
                        <span class="d-inline">标记与拍照，在订单备注处备注标记内容</span>
                    </div>
                </div>
            </div>

            <!-- Note -->
            <div id="note" class="mb-3">
                <div class="mb-2">
                    <span class="text-left"><b>备注</b></span>
                </div>
                <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                    <textarea v-model="order_info.note" class="border-0 w-100" name="note"
                              placeholder="在此处填写备注信息"></textarea>
                </div>
            </div>

            <!-- Summary -->
            <div id="summary" class="mb-3">
                <div v-if="order_info.addon == true" class="bg-white row pl-3 pr-3 pt-2 pb-2">
                    <div class="w-100">
                        <span>增值服务</span>
                        <span class="float-right">AUD $1</span>
                    </div>
                </div>
                <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                    <div class="w-100" style="font-size:18px">
                        <span><b>商品合计</b><span class="small">(不含运费)</span></span>
                        <span class="float-right text-danger fa-1x">AUD $<span>{{calculate_total}}</span></span>
                    </div>
                </div>

            </div>

            <!-- List of products in order that needs to be sorted -->
            <div v-if="order.products.length != 0">
                <div class="w-100">
                    <div class="alert alert-danger text-center">
                        待分箱产品
                    </div>
                </div>
                <div v-for="product in order.products" class="row bg-white pt-2 pb-2">
                    <div class="col-3">
                        <img v-bind:src="'../../storage/app/'+product.img_url" class="img-thumbnail">
                    </div>
                    <div class="col-9 pl-0">
                        <div class="align-top">
                            <div>{{product.name}} <span class="float-right text-danger small"> 数量:{{product.num}}</span>
                            </div>
                            <div class="text-danger">AUD ${{product.price}}</div>
                            <div class="text-muted small">规格：{{product.spec}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else>
                <div class="w-100">
                    <div class="alert alert-success text-center">
                        分箱完成
                    </div>
                </div>
            </div>

            <!--Order Product: {{order.products}}
            <br>
            Selected Product: {{selected_product}}
            <br>
            Package: {{packages}}-->
            <div class="row">
                <hr class="w-100">
            </div>

            <!-- List of products that are sorted -->
            <div>
                <div v-for="(each_package,index) in packages">
                    <div class="card mb-3">
                        <div class="card-header p-2">包裹{{index+1}}
                            <span v-if="each_package.products.length == 0" class="text-danger">空</span>
                            物流公司: {{each_package.delivery_company.name}}
                            <span v-on:click="remove_package(each_package)" class="float-right"><u>移除包裹</u></span>
                            <br>
                            <span>
                                收件人: {{each_package.sending_address.name}},{{each_package.sending_address.phone}}
                            </span>
                        </div>
                        <div v-if="each_package.products.length != 0" class="card-body p-2">
                            <div v-for="product in each_package.products" class="container-fluid bg-white">
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <img v-bind:src="'../../storage/app/'+product.img_url" class="img-thumbnail">
                                    </div>
                                    <div class="col-9 pl-0">
                                        <div class="align-top">
                                            <div>{{product.name}} <span class="float-right text-danger small">数量:{{product.quantity}}</span>
                                            </div>
                                            <div class="text-danger">AUD ${{product.price}}</div>
                                            <div class="text-muted small">规格：{{product.spec}}<span
                                                    v-on:click="remove_from_package(each_package,product)"
                                                    class="float-right"><u>移除</u></span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-center p-1">
                            <button v-on:click="select_package(index)" type="button" data-toggle="modal"
                                    data-target="#add-product">
                                <u>添加商品</u>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- add products to package modal -->
                <div class="modal fade" id="add-product" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">添加到包裹{{to_package.index+1}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-4 pl-0 pr-1 text-dark text-right"
                                           style="font-size: medium; ">选择商品:</label>
                                    <div class="col-8">
                                        <select v-model="selected_product" class="form-control">
                                            <template v-for="product in order.products">
                                                <option v-bind:value="product">{{product.name}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div v-if="selected_product != null" class="form-group row">
                                    <label class="col-form-label col-4 pl-0 pr-1 text-dark text-right"
                                           style="font-size: medium; ">选择数量:</label>
                                    <div class="col-8">
                                        <select v-model="selected_quantity" class="form-control">
                                            <template v-for="(quantity,index) in selected_product.num">
                                                <option v-bind:value="quantity" v-bind="{selected : index == 0}">
                                                    {{quantity}}
                                                </option>
                                            </template>
                                        </select>
                                    </div>
                                </div>

                                <button v-on:click="add_to_package" class="btn btn-danger btn-block mt-3"
                                        v-bind="{ disabled : cannot_add}">添加
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- add package modal -->
                <div class="modal fade" id="add-package" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">添加新包裹</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-4 pl-0 pr-1 text-right" style="font-size:medium">选择快递:</label>
                                    <div class="col-8">
                                        <select v-model="new_package.company" class="form-control">
                                            <template v-for="option in companies">
                                                <option v-bind:value="option">{{option.name}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div v-if="new_package.company != null" class="form-group row text-center">
                                    <div class="w-100">运费: {{new_package.company.price}}/kg <a
                                            v-bind:href="new_package.company.link" class="text-danger"><u>查看打包规则</u></a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-4 pl-0 pr-1 text-right" style="font-size:medium">选择收件人:</label>
                                    <div class="col-8">
                                        <select v-model="new_package.sending_address" class="form-control">
                                            <template v-for="option in order.sending_addresses">
                                                <option v-bind:value="option">
                                                    {{option.name}},{{option.phone}},{{option.province}} {{option.city}}
                                                    {{option.suburb}}
                                                </option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div v-if="new_package.sending_address != null"
                                     class="text-center text-muted">
                                    <span>详细地址：{{new_package.sending_address.detail}}</span>
                                </div>

                                <div class="w-100 text-center mt-2">
                                    <span v-on:click="to_addresses" class="text-danger"><i class="fas fa-user-plus"></i> <a><u>新增收件人</u></a> </span>
                                </div>
                                <button v-on:click="add_more_package" class="btn btn-danger btn-block mt-3"
                                        v-bind="{ disabled : new_package.company == null || new_package.sending_address == null}">
                                    添加
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- add more packages -->
            <div class="w-100 text-center mb-3">
                <button data-toggle="modal" data-target="#add-package" class="btn-outline-danger btn"
                        v-bind="{disabled : order.products.length == 0}">添加包裹
                </button>
            </div>
            <form method="post" action="../" class="mt-3">
                <slot></slot>
                <button class="w-100 btn btn-block btn-danger" type="submit"
                        v-bind="{disabled : order.products.length > 0 || info_completed}">
                    确认并提交
                </button>
            </form>

        </div>

    </div>
</template>

<style>

    select {

        /* styling */
        background-color: white;
        border: thin solid #e7e7e7;
        border-radius: 4px;
        display: inline-block;
        font: inherit;
        line-height: 1.5em;
        padding: 0.5em 3.5em 0.5em 1em;

        /* reset */

        margin: 0;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    select.minimal {
        background-image: linear-gradient(45deg, transparent 50%, gray 50%),
        linear-gradient(135deg, gray 50%, transparent 50%),
        linear-gradient(to right, #ccc, #ccc);
        background-position: calc(100% - 20px) calc(1em + 2px),
        calc(100% - 15px) calc(1em + 2px),
        calc(100% - 2.5em) 0.5em;
        background-size: 5px 5px,
        5px 5px,
        1px 1.5em;
        background-repeat: no-repeat;
    }

    select.minimal:focus {
        background-image: linear-gradient(45deg, green 50%, transparent 50%),
        linear-gradient(135deg, transparent 50%, green 50%),
        linear-gradient(to right, #ccc, #ccc);
        background-position: calc(100% - 15px) 1em,
        calc(100% - 20px) 1em,
        calc(100% - 2.5em) 0.5em;
        background-size: 5px 5px,
        5px 5px,
        1px 1.5em;
        background-repeat: no-repeat;
        border-color: green;
        outline: 0;
    }

    select:-moz-focusring {
        color: transparent;
        text-shadow: 0 0 0 #000;
    }
</style>

<script>
    export default {
        props: ['orderData', 'userCredits'],
        data() {
            return {
                order: null,
                order_info: {
                    sender_address: null,
                    addon: false,
                    note: null
                },
                sender_address: null,
                submit_btn: null,
                sorted: [],
                packages: [],
                to_package: [],
                new_package: {
                    'company': null,
                    'sending_address': null
                },
                selected_product: null,
                selected_quantity: null,
                companies: [
                    {
                        value: "4px",
                        name: "四方转运",
                        link: "",
                        price: 5
                    },
                    {
                        value: "lantian",
                        name: "蓝天",
                        link: "",
                        price: 4
                    },
                    {
                        value: "shunfeng",
                        name: "顺丰",
                        link: "",
                        price: 6
                    }
                ]
            }
        },
        computed: {
            /*can_add_more: function(){
                if(this.packages.length == 0){
                    return true;
                }
                var result = true;
                _.filter(this.packages, each_package => {
                    if(each_package.length == 0){
                        result = false;
                    }
                });
                return result;
            }*/
            cannot_add: function () {
                if (this.selected_product == null) {
                    return true;
                }
                if (this.selected_quantity == null) {
                    return true;
                }
                return false;
            },
            info_completed: function () {
                if (this.order_info.sender_address == null) {
                    return true;
                }
                return false;
            },
            calculate_total: function () {
                if (this.order_info.addon == true) {
                    return parseFloat(this.order.total) + 1;
                } else {
                    return parseFloat(this.order.total);
                }
            }
        },
        created() {
            this.order = JSON.parse(this.orderData);
            if (this.order.payment_link != null) {
                this.sending_detail = this.order.sending_address.detail;
                this.sender_detail = this.order.sender_address.detail;
            }
        },
        methods: {
            to_addresses() {
                window.location.href = "../addresses"
            },
            add_more_package() {
                var i = 0;
                this.packages.push({
                    index: i + this.packages.length,
                    products: [],
                    delivery_company: this.new_package.company,
                    sending_address: this.new_package.sending_address
                });
                $('#add-package').modal('hide');
            },
            select_package(index) {
                _.filter(this.packages, each_package => {
                    if (each_package.index == index) {
                        this.to_package = each_package;
                    }
                });
            },
            add_to_package() {
                /* check if product already exists in package */
                var existed = false;
                var quantity = this.selected_quantity;
                if (quantity > this.selected_product.num) {
                    quantity = this.selected_product.num;
                }
                _.filter(this.to_package.products, product => {
                    if (product.id == this.selected_product.id) {
                        existed = true;
                        product.quantity += quantity;
                        this.selected_product.num -= quantity;
                    }
                });

                /* add product to package if it's not exist */
                if (existed == false) {
                    this.selected_product.num -= quantity;
                    let product = Object.assign({quantity: quantity}, this.selected_product);
                    this.to_package.products.push(product);
                }

                /* remove products from unpacked products */
                if (this.selected_product.num <= 0) {
                    this.order.products = this.order.products.filter(product => product.id !== this.selected_product.id);
                }

                /* close modal and clear selected product */
                $('#add-product').modal('hide');
                this.selected_product = null;
                this.selected_quantity = null;
            },

            remove_from_package(from_package, product) {
                /* check if product already exists in order products */
                var existed = false;
                var quantity = product.quantity;
                _.filter(this.order.products, each_product => {
                    if (each_product.id == product.id) {
                        existed = true;
                        each_product.num += quantity;
                    }
                });

                /* add product to order products if it's not exist */
                if (existed == false) {
                    product.num = quantity;
                    delete product.quantity;
                    let p = Object.assign({}, product);
                    this.order.products.push(p);
                }

                /* remove products from unpacked products */
                from_package.products = from_package.products.filter(each_product => each_product.id !== product.id);

            },
            remove_package(which_package) {
                _.filter(which_package.products, product => {
                    this.remove_from_package(which_package, product);
                });
                this.packages = this.packages.filter(each_package => each_package.index !== which_package.index);
            },
            submit_order(){

            }
        }
    }
</script>