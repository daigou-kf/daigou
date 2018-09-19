<template>
    <div id="staff-package">
        <div class="w-100 bg-secondary text-center text-white v-center-sm mb-3">
            <h3>订单未分箱</h3>
        </div>

        <!-- products that are not packed -->
        <div v-if="order.products.length != 0" class="container-fluid mb-3">
            <table class="table table-borderless table-shadow bg-white">
                <thead class="bg-secondary text-light">
                <th>产品</th>
                <th>规格</th>
                <th class="text-right">数量</th>
                </thead>
                <template v-for="product in order.products">
                    <tr>
                        <td>{{product.name}}</td>
                        <td>{{product.spec}}</td>
                        <td class="text-right">{{product.num}}</td>
                    </tr>
                </template>
            </table>
        </div>

        <!-- packages -->
        <div v-if="order.packages.length != 0" class="container-fluid mb-3">
            <div class="bg-white table-shadow">
                <div v-for="(each_package,index) in order.packages" class="mb-2">
                    <div class="row ml-3 mr-3">
                        <div class="col-4"><span v-on:click="remove_package(each_package)" class="text-blue"><i class="fas fa-minus-circle"></i></span> 包裹{{index+1}}</div>
                        <div class="col-4">单号: {{each_package.deli_no}}</div>
                        <div class="col-4 text-right">运费: ${{each_package.fee}}</div>
                    </div>
                    <div v-for="product in each_package.products" class="row ml-3 mr-3">
                        <div class="col-4 pr-0 text-right"><span v-on:click="remove_from_package(each_package,product)" style="color: #ee2f54"><i class="fas fa-minus-circle"></i></span></div>
                        <div class="col-4">{{product.name}}</div>
                        <div class="col-4 text-right">{{product.quantity}}</div>
                    </div>
                    <div class="row ml-3 mr-3">
                        <div class="col-4 offset-4">
                            <button v-on:click="select_package(each_package)" data-toggle="modal" data-target="#add-product" class="btn btn-red text-white p-0" style="font-size: 12px" v-bind="{disabled : order.products.length == 0}"><span><i class="fas fa-plus"></i></span> 添加商品</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- add more packages -->
        <div class="w-100 text-center mb-3">
            <button data-toggle="modal" data-target="#add-package" class="btn-lightblue btn text-white"
                    v-bind="{disabled : order.products.length == 0}"> <i class="fas fa-plus"></i> 添加包裹
            </button>
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

                        <div class="form-group row">
                            <label class="col-form-label col-4 pl-0 pr-1 text-right" style="font-size:medium">运单号:</label>
                            <div class="col-8">
                                <input type="text" v-model="new_package.deli_no" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-4 pl-0 pr-1 text-right" style="font-size:medium">运费:</label>
                            <div class="col-8">
                                <input type="number" step="0.01" v-model="new_package.fee" class="form-control">
                            </div>
                        </div>
                        <div class="container-fluid text-center">
                            <button v-on:click="add_more_package()" class="btn btn-red text-white mt-3"
                                    v-bind="{ disabled : new_package.company == null || new_package.deli_no == null || new_package.fee == null}">
                                添加
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  add product to package modal -->
        <div class="modal fade" id="add-product" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">添加到包裹</h5>
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
                        <div class="container-fluid text-center">
                            <button v-on:click="add_to_package()" class="btn btn-red text-white mt-3"
                                    v-bind="{ disabled : selected_product == null || selected_quantity == null}">添加
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</template>

<script>
    export default {
        data(){
            return{
                order: null,
                new_package: {
                    'company': null,
                    'deli_no': null,
                    'fee': null
                },
                selected_package: null,
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
        created(){
            this.order = this.$parent.order;
        },
        methods: {
            add_more_package() {
                this.order.packages.push({
                    products: [],
                    delivery_company: this.new_package.company,
                    deli_no: this.new_package.deli_no,
                    fee: this.new_package.fee
                });
                this.new_package = {
                    'company': null,
                    'deli_no': null,
                    'fee': null
                };
                $('#add-package').modal('hide');
            },
            select_package(which_package){
                this.selected_package = which_package;
            },
            add_to_package(){
                /* check if product already exists in package */
                var existed = false;
                var quantity = this.selected_quantity;
                if (quantity > this.selected_product.num) {
                    quantity = this.selected_product.num;
                }
                _.filter(this.selected_package.products, product => {
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
                    this.selected_package.products.push(product);
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
                this.order.packages = this.order.packages.filter(each_package => each_package.index !== which_package.index);
            },
        }
    }
</script>