<template>
    <div id="order-show-page" class="mb-5 pb-3 mt-3">
        <form id="order-form" method="POST" v-bind:action="'/daigou/mall/create_transaction'">
            <input type="hidden" name="_token">
            <input type="hidden" name="order_id" v-model="order.id">
            <div class="container-fluid">
                <div>
                    <h5><b>订单号：{{("000000000" + order.id).slice(-9)}}</b></h5>
                </div>
                <!-- List of products in order -->
                <div v-for="product in order.products" class="row bg-white pt-2 pb-2 mb-3">
                    <div class="col-3">
                        <img v-bind:src="'../../storage/app/'+product.img_url" class="img-thumbnail">
                    </div>
                    <div class="col-9 pl-0">
                        <div class="align-top">
                            <div>{{product.name}}</div>
                            <div class="text-danger">AUD ${{product.price}}</div>
                            <div class="text-muted small">重量：{{product.weight}}g</div>
                            <div class="text-right small text-danger">数量：{{product.num}}</div>
                        </div>
                    </div>
                </div>

                <!-- Sending Address -->
                <div id="sending-address" class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>收货地址</b> </span>
                        <span v-if="order.status == 0" v-on:click="to_addresses" class="float-right text-danger"><i
                                class="fas fa-user-plus"></i> <a><u>新增收件人</u></a> </span>
                    </div>
                    <div class="bg-white text-center row">
                        <select v-if="order.status == 0 && order.payment_link == null" id="sending-detail"
                                v-on:change="show_sending_detail"
                                v-model="order.address_id" name="address_id"
                                class="minimal text-center w-100 pt-2 pb-2 text-center" required>
                            <option v-for="sending_address in order.sending_addresses" v-bind:value="sending_address.id"
                                    v-bind:detail="sending_address.detail">
                            <span>
                                {{sending_address.name}} , {{sending_address.phone}} , {{sending_address.province}} {{sending_address.city}}
                            {{sending_address.suburb}}
                            </span>
                            </option>
                        </select>
                        <div v-else class="text-center w-100 pt-2 pb-2">
                            {{order.sending_address.name}} , {{order.sending_address.phone}} ,
                            {{order.sending_address.province}} {{order.sending_address.city}}
                            {{order.sending_address.suburb}}
                        </div>

                    </div>
                    <div v-if="order.address_id != null && order.address_id != 'null'"
                         class="text-center text-muted pt-2 pb-2">
                        <span>详细地址：{{sending_detail}}</span>
                    </div>
                </div>

                <!-- Sender Address -->
                <div id="sender-address" class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>发件人</b> </span>
                        <span v-if="order.status == 0" v-on:click="to_addresses" class="float-right text-danger"><i
                                class="fas fa-user-plus"></i> <a><u>新增发件人</u></a> </span>
                    </div>
                    <div class="bg-white text-center row">
                        <select v-if="order.status == 0 && order.payment_link == null" id="sender-detail"
                                v-on:change="show_sender_detail" v-model="order.sender_address_id"
                                class="minimal w-100 pt-2 pb-2 text-center" name="sender_address_id" required>
                            <option v-for="sender_address in order.sender_addresses" v-bind:value="sender_address.id"
                                    v-bind:detail="sender_address.detail">
                                {{sender_address.name}}, {{sender_address.phone}}
                            </option>
                        </select>
                        <div v-else class="text-center w-100 pt-2 pb-2">
                            {{order.sender_address.name}} , {{order.sender_address.phone}}
                        </div>

                    </div>
                    <div v-if="order.sender_address_id != null && order.sender_address_id != 'null'"
                         class="text-center text-muted pt-2 pb-2">
                        详细地址：{{sender_detail}}
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

                <!-- Delivery method -->
                <div id="delivery-method" class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>物流方式</b></span>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100">
                            <span class="text-left">四方转运</span>
                            <span><i class="fas fa-check float-right text-danger" style="font-size:20px"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Images -->
                <div v-if="order.deli_images != null && order.status >= 2" id="deli_images" class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>运单号图片</b></span>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div v-for="img in order.deli_images" class="col-6 col-lg-2 col-md-3 col-sm-4">
                            <a v-bind:href="'/daigou/storage/app/'+img" target="_blank">
                                <img class="img-thumbnail" v-bind:src="'/daigou/storage/app/'+img">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Delivery Detail -->
                <div v-if="order.status >= 2 && order.delivery_no" id="delivery-detail" class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>物流追踪</b></span>
                    </div>
                    <div class="mb-3" v-for="deli_no in order.delivery_no">
                        <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                            <a class="w-100 text-dark" data-toggle="collapse" href="#delivery-detail-content"
                               role="button"
                               aria-expanded="false" aria-controls="delivery-detail-content">
                                <div v-on:click="track_delivery(deli_no)" class="w-100">
                                    <span class="show-button text-left"> {{deli_no}} </span>
                                    <span class="float-right"><i class="fas fa-chevron-right"
                                                                 style="font-size:20px"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="collapse" id="delivery-detail-content">
                        <div v-if="delivery_loading == 1">
                            <div class="mb-2 mt-2">
                                加载中...
                            </div>
                        </div>
                        <div v-else>
                            <div v-if="delivery_detail.EndDeliverySupplierName" class="mb-2 mt-2">
                                物流公司:{{delivery_detail.EndDeliverySupplierName}}
                            </div>
                            <div v-for="delivery_record in this.delivery_detail.tracks" class="row mb-2">
                                <div class="col-8">
                                    <span class="text-left">{{delivery_record.TrackContent}}</span>
                                </div>
                                <div class="col-4">
                                    <span class="float-right">{{delivery_record.CreateDate}}</span>
                                </div>
                            </div>
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
                            <input v-if="order.status == 0 && order.payment_link == null" v-model="addon_checked"
                                   name="addon" type="checkbox">
                            <i v-else-if="order.addon == 0" class="fas fa-times"></i>
                            <i v-else class="fas fa-check"></i>
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
                        <textarea v-if="order.status == 0 && order.payment_link == null" v-model="order.note"
                                  class="border-0 w-100" name="note" placeholder="在此处填写备注信息"></textarea>
                        <div v-else>
                            <div v-if="order.note" class="text-center">
                                {{order.note}}
                            </div>
                            <div v-else class="text-center">
                                无备注
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Use Credits -->
                <div id="credits" class="mb-3">
                    <div class="mb-2">
                        <div class="w-100">
                            <span class="text-left"><b>使用余额</b></span>
                            <span v-if="order.payment_link != null" class="float-right">{{order.credits}}</span>
                            <span v-else class="float-right">您的余额:{{(user_credits)}}</span>
                        </div>
                    </div>
                    <div v-if="order.payment_link == null" class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <input v-model="order.credits" v-bind:onchange="check_credits()" class="border-0 w-100"
                               name="credits" placeholder="在此处填写使用的余额">
                    </div>
                </div>

                <!-- Images -->
                <div v-if="order.images != null && order.addon == 1 && order.status >= 2" id="images" class="mb-3">
                    <div class="mb-2">
                        <span class="text-left"><b>增值服务图片</b></span>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div v-for="img in order.images" class="col-6 col-lg-2 col-md-3 col-sm-4">
                            <a v-bind:href="'/daigou/storage/app/'+img" target="_blank">
                                <img class="img-thumbnail" v-bind:src="'/daigou/storage/app/'+img">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div id="summary" class="mb-3">
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100">
                            <span>总数量</span>
                            <span class="float-right">{{order.quantity}}</span>
                        </div>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100">
                            <span>总重量</span>
                            <span class="float-right">{{order.weight}}g</span>
                        </div>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100">
                            <span>总运费 (1kg起，4.8/kg)</span>
                            <span class="float-right">AUD ${{order.weight_fee}}</span>
                        </div>
                    </div>
                    <div v-if="addon_checked == true" class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100">
                            <span>增值服务</span>
                            <span class="float-right">AUD $1</span>
                        </div>
                    </div>
                    <div class="bg-white row pl-3 pr-3 pt-2 pb-2">
                        <div class="w-100" style="font-size:18px">
                            <span><b>商品合计</b></span>
                            <span class="float-right text-danger fa-1x">AUD $<span v-if="addon_checked == true && order.payment_link == null"> {{(parseFloat(order.total) + 1 - order.credits).toFixed(2)}}</span><span v-else>{{(parseFloat(order.total) - order.credits).toFixed(2)}}</span></span>
                        </div>
                    </div>
                    <div class="row">
                        <a v-if="order.status == 2" href="http://au.transrush.com/wx/idcard"
                           class="btn btn-block btn-info text-light">上传身份证</a>
                        <input v-on:click="assign_token" v-if="order.status == 0" id="submit-button" type="submit"
                               class="btn btn-danger btn-block" value="去支付">
                        <button v-else-if="order.status == 1" class="btn btn-block btn-secondary" disabled>已支付</button>

                        <button v-else-if="order.status == 3" class="btn btn-block btn-secondary" disabled>已完成</button>

                    </div>

                </div>

            </div>
        </form>
        <button v-if="order.status == 2" v-on:click="confirm_order(order.id)"
                class="w-100 btn btn-block btn-success">
            确认收货
        </button>
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
                order: '',
                user_credits: '',
                sending_detail: '',
                sender_detail: '',
                addon_checked: '',
                delivery_loading: 0,
                delivery_detail: []
            }
        },
        created() {
            this.order = JSON.parse(this.orderData);
            this.user_credits = this.userCredits;
            if (this.order.status != 0 || this.order.payment_link != null) {
                this.sending_detail = this.order.sending_address.detail;
                this.sender_detail = this.order.sender_address.detail;
            }
            if (this.order.addon == 1) {
                this.addon_checked = true;
            }
        },
        methods: {
            to_addresses() {
                window.location.href = "../addresses"
            },
            show_sending_detail() {
                this.sending_detail = $("#sending-detail option:selected").attr('detail');
            },
            show_sender_detail() {
                this.sender_detail = $("#sender-detail option:selected").attr('detail');
            },
            assign_token() {
                $('#order-form input[name="_token"]').val($('meta[name="csrf-token"]').attr('content'));
                this.disable_submit_btn();
                $('#order-form').submit();
            },
            confirm_order(order_id) {
                $.ajax({
                    url: '/daigou/mall/confirm_order',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'order_id': order_id
                    },
                    dataType: 'json',
                    success: function (response) {

                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
                window.location.href = "/daigou/mall/orders";
            },
            track_delivery(delivery_no) {
                this.delivery_loading = 1;
                $.ajax({
                    url: '/daigou/mall/track_delivery/' + delivery_no,
                    method: 'GET',
                    success: function (response) {

                    },
                    error: function (error) {
                        console.log(error);
                    }
                }).done(data => {
                    this.$set(this.delivery_detail, 'tracks', data[0]['tracks']);
                    this.$set(this.delivery_detail, 'EndDeliverySupplierName', data[0]['EndDeliverySupplierName']);
                    this.delivery_loading = 0;
                });
            },
            check_credits() {
                if (this.addon_checked == true) {
                    if (parseFloat(this.order.credits) > parseFloat(this.user_credits)) {
                        this.order.credits = parseFloat(this.user_credits).toFixed(2);
                    }
                    if (parseFloat(this.order.credits) > parseFloat(this.order.total) + 1) {
                        this.order.credits = (parseFloat(this.order.total) + 1).toFixed(2);
                    }
                } else {
                    if (parseFloat(this.order.credits) > parseFloat(this.user_credits)) {
                        this.order.credits = parseFloat(this.user_credits).toFixed(2);
                    }
                    if (parseFloat(this.order.credits) > parseFloat(this.order.total)) {
                        this.order.credits = parseFloat(this.order.total).toFixed(2);
                    }
                }

            },
            disable_submit_btn(){
                $('#submit-button').prop('disabled',true);
            }
        }
    }
</script>