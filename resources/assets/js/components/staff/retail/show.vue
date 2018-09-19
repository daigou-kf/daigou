<template>
    <div id="staff-order-show" class="mb-5">
        <div class="container-fluid text-center p-3 text-blue">
            <h4>订单号: {{order.id}}</h4>
        </div>

        <!-- order info -->
        <div class="container-fluid mb-3">
            <div id="info-content" class="bg-white table-shadow">
                <!-- sender info -->
                <div class="row ml-3 mr-3 bg-white">
                    <div class="col-4">发件人:</div>
                    <div class="col-3">姓名:</div>
                    <div class="col-5 text-right">{{order.sender.name}}</div>
                </div>
                <div class="row ml-3 mr-3 bg-white">
                    <div class="col-4"></div>
                    <div class="col-3">电话:</div>
                    <div class="col-5 text-right">{{order.sender.phone}}</div>
                </div>

                <!-- orders that is already packed -->
                <template v-if="order.package_method == 'auto'">
                    <!-- receiver info -->
                    <div class="row ml-3 mr-3 bg-white mt-3">
                        <div class="col-4">收件人:</div>
                        <div class="col-3">姓名:</div>
                        <div class="col-5 text-right">{{order.sending.name}}</div>
                    </div>
                    <div class="row ml-3 mr-3 bg-white">
                        <div class="col-4"></div>
                        <div class="col-3">电话:</div>
                        <div class="col-5 text-right">{{order.sending.phone}}</div>
                    </div>
                    <div class="row ml-3 mr-3 bg-white">
                        <div class="col-4"></div>
                        <div class="col-3">地址:</div>
                        <div class="col-5 text-right">{{order.sending.address}}</div>
                    </div>
                </template>
            </div>
        </div>

        <template v-if="order.package_method == 'auto'">
            <staff-package></staff-package>
        </template>
        <template v-else-if="order.package_method == 'self'">
            <div class="w-100 bg-gold text-center text-white v-center-sm mb-3">
                <h3>
                    <template v-if="selected_package == null">
                        订单已分箱
                    </template>
                    <template v-else>
                        添加包裹信息
                    </template>
                </h3>
            </div>

            <template v-if="selected_package == null">
                <div v-for="(each_package,index) in order.packages" class="container-fluid mb-3">
                    <div class="bg-white table-shadow">
                        <div class="row ml-3 mr-3">
                            <div class="col-3 p-2">包裹{{index+1}}</div>
                            <div class="col-6 p-2">
                                <div>收件人姓名: {{each_package.sending.name}}</div>
                                <div>快递公司: {{each_package.company.alias}}</div>
                                <hr class="m-2">
                                <div v-for="product in each_package.products">
                                    <span>{{product.name}}</span>
                                    <span class="float-right">{{product.quantity}}</span>
                                </div>
                            </div>
                            <div class="col-3 p-2 text-right">
                                <template v-if="each_package.status == 0">
                                    <button v-on:click="fill_package(each_package)" class="btn btn-secondary p-0">待配货</button>
                                </template>
                                <template v-else>
                                    <button class="btn btn-gold text-white p-0">已配货</button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="container-fluid mb-3">
                    <table class="table table-borderless table-shadow bg-white">
                        <thead class="bg-secondary text-light">
                            <th>产品</th>
                            <th>规格</th>
                            <th class="text-right">数量</th>
                        </thead>
                        <template v-for="product in selected_package.products">
                            <tr>
                                <td>{{product.name}}</td>
                                <td>{{product.spec}}</td>
                                <td class="text-right">{{product.quantity}}</td>
                            </tr>
                        </template>
                    </table>
                </div>

                <div class="container-fluid mb-3">
                    <div class="bg-white table-shadow pt-3">
                        <div class="form-group row pl-3 pr-3">
                            <label class="col-form-label col-4 pl-0 pr-1 text-right" style="font-size:medium">上传配货图片:</label>
                            <div class="col-8">
                                <input class="form-control" type="file" accept="image/*" v-on:change="store_file($event)">
                            </div>
                        </div>
                        <div class="form-group row pl-3 pr-3">
                            <label class="col-form-label col-4 pl-0 pr-1 text-right" style="font-size:medium">输入单号:</label>
                            <div class="col-8">
                                <input class="form-control" type="text" v-model="package_info.deli_no">
                            </div>
                        </div>
                        <div class="form-group row pl-3 pr-3">
                            <label class="col-form-label col-4 pl-0 pr-1 text-right" style="font-size:medium">输入运费:</label>
                            <div class="col-8">
                                <input class="form-control" type="number" step="0.01" v-model="package_info.fee">
                            </div>
                        </div>
                        <div class="row justify-content-center pb-3">
                            <button v-on:click="submit_package_info()" class="btn btn-red mt-2 text-white"
                                    v-bind="{ disabled : !package_info_complete}">
                                上传
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </template>

        <div class="container-fluid fixed-bottom">
            <div class="row">
                <button v-on:click="submit_order()" class="btn btn-block btn-blue text-white" v-bind="{disabled : !can_submit}">确认并提交</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                order: null,
                selected_package: null,
                package_info: {
                    images: null,
                    deli_no: null,
                    fee: null
                }
            }
        },
        created() {
            _.filter(this.$parent.all_orders, each_order => {
                if (each_order.id == this.$route.params.id) {
                    this.order = each_order;
                }
            })
        },
        computed: {
            can_submit: function(){
                if(this.order.package_method == 'self'){
                    var result = 0;
                    _.filter(this.order.packages, each_package => {
                        if(each_package.status == 0){
                            result++;
                        }
                    });
                    if(result == 0){
                        return true;
                    } else {
                        return false;
                    }
                }
                if(this.order.package_method == 'auto'){
                    if(this.order.products.length != 0){
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            package_info_complete: function(){
                if(this.package_info.images == null || this.package_info.deli_no == null || this.package_info.fee == null){
                    return false;
                } else {
                    return true;
                }
            }
        },
        methods: {
            fill_package(which_package){
                this.selected_package = which_package;
            },
            store_file(event){
                this.package_info.images = event.target.files[0];
            },

            submit_package_info(){
                this.selected_package.status = 1;
                this.selected_package = null;
                this.package_info.images = null;
                this.package_info.deli_no = null;
                this.package_info.fee = null;
            },
            submit_order(){
                this.order.status = 2;
                this.$router.push({name: 'StaffHome'});
            }
        }
    }
</script>