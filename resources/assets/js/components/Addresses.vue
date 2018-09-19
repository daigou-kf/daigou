<template>
    <div class="container-fluid mb-5">

        <!-- Sending Address Modal -->
        <div class="modal fade" id="address-form" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <div v-if="edit == 'false'">新收货地址</div>
                            <div v-else>编辑地址</div>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="sending-address-form" method="post" @submit.prevent="update_sending_address">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">收件人姓名</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="sending_address.name" required
                                           autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">电话</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="sending_address.phone" required
                                           autofocus>
                                </div>
                            </div>
                            <div v-if="edit == 'true'" class="form-group">
                                <span>地址：{{province}},{{city}},{{suburb}},{{detail}}</span>
                                <button class="btn btn-secondary mb-2 mt-2 btn-block" type="button"
                                        data-toggle="collapse" data-target="#detail-section" aria-expanded="false"
                                        aria-controls="detail-section">
                                    更改地址
                                </button>
                            </div>
                            <div v-bind:class="{'collapse':edit == 'true'}" id="detail-section">
                                <div class="form-group">
                                    <label class="col-form-label text-md-right">省市区</label>
                                    <select class="form-control" id="province" name="province"
                                            v-model="sending_address.province" onchange="changeSelect(this);"
                                            v-bind="{'required':edit == 'false'}">
                                        <option value="000000" style="color:#999;" disabled="disabled" selected>-请选择省-
                                        </option>
                                    </select>
                                    <select class="form-control" id="city" name="city" v-model="sending_address.city"
                                            onchange="changeSelect(this);" v-bind="{'required':edit == 'false'}">
                                        <option value="000000" style="color:#999;" disabled="disabled">-请选择市-</option>
                                    </select>
                                    <select class="form-control" id="suburb" v-model="sending_address.suburb"
                                            name="suburb" v-bind="{'required':edit == 'false'}">
                                        <option value="000000" style="color:#999;" disabled="disabled">-请选区-</option>
                                    </select>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">详细地址</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" v-model="sending_address.detail"
                                               v-bind="{'required':edit == 'false'}"
                                               autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <div v-if="edit=='false'">创建</div>
                                        <div v-else>更新</div>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sender Address Modal -->
        <div class="modal fade" id="sender-address-form" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <div v-if="edit=='false'">新发货地址</div>
                            <div v-else>编辑地址</div>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" @submit.prevent="update_sender_address">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">发件人姓名</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="sender_address.name" required
                                           autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">详细地址（选填）</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="sender_address.detail">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">电话</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="sender_address.phone" required
                                           autofocus>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <div v-if="edit=='false'">
                                            创建
                                        </div>
                                        <div v-else>
                                            更新
                                        </div>

                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tabs -->
        <div class="row">
            <ul class="nav nav-pills w-100 text-center" id="pills-tab" role="tablist">
                <li class="nav-item w-50">
                    <a v-on:click="fetch_sending_addresses" class="nav-link active bg-white text-danger"
                       id="pills-addresses-tab"
                       data-toggle="pill" href="#addresses" role="tab"
                       aria-controls="addresses" aria-selected="true">收货地址</a>
                </li>
                <li class="nav-item w-50">
                    <a v-on:click="fetch_sender_addresses" class="nav-link bg-white text-danger"
                       id="pills-sender-addresses-tab"
                       data-toggle="pill" href="#sender-addresses"
                       role="tab" aria-controls="sender-addresses" aria-selected="false">发货地址</a>
                </li>
            </ul>
        </div>
        <hr>


        <div class="tab-content" id="pills-tabContent">

            <!-- Sending Addresses -->
            <div class="tab-pane fade show active" id="addresses" role="tabpanel" aria-labelledby="pills-addresses-tab">
                <div class="row list-group">
                    <a v-for="sending_address in sending_addresses" v-on:click="change_sending_edit(sending_address)"
                       data-toggle="modal"
                       data-target="#address-form">
                        <div class="w-100 list-group-item list-group-item-action bg-white mb-3"
                             v-bind:key="sending_address.id">
                            <span style="font-size: 22px">{{sending_address.name}} , {{sending_address.phone}}</span>

                            <div class="float-right">
                                <img style="height:50px;width:50px"
                                     v-bind:src="'/daigou/storage/app/assets/me_icon_nextpage_default@2x.png'">

                            </div>
                            <div>
                            <span class="text-muted small">{{sending_address.province}} {{sending_address.city}} {{sending_address.suburb}}
                                {{sending_address.detail}}
                            </span>
                            </div>

                        </div>
                    </a>
                </div>


                <div class="row mb-3">
                    <div class="w-100 text-center">
                        <button v-on:click="change_sending_new" type="button" class="btn btn-outline-danger"
                                data-toggle="modal"
                                data-target="#address-form">新增收件人 <i class="fas fa-user-plus"></i></button>
                    </div>
                </div>
            </div>

            <!-- Sender Addresses -->
            <div class="tab-pane fade" id="sender-addresses" role="tabpanel"
                 aria-labelledby="pills-sender-addresses-tab">
                <div class="row list-group">
                    <a v-for="sender_address in sender_addresses" v-on:click="change_sender_edit(sender_address)"
                       data-toggle="modal"
                       data-target="#sender-address-form">
                        <div class="list-group-item list-group-item-action bg-white mb-3"
                             v-bind:key="sender_address.id">
                            <span style="font-size: 22px">{{sender_address.name}} , {{sender_address.phone}}</span>
                            <div class="float-right">
                                <img style="height:50px;width:50px"
                                     v-bind:src="'/daigou/storage/app/assets/me_icon_nextpage_default@2x.png'">

                            </div>
                            <div>
                            <span v-if="sender_address.detail" class="text-muted small">
                                {{sender_address.detail}}
                            </span>
                                <span v-else class="text-muted small">
                                未添加
                            </span>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="row mb-3">
                    <div class="w-100 text-center">
                        <button v-on:click="change_sender_new" type="button" class="btn btn-outline-danger"
                                data-toggle="modal"
                                data-target="#sender-address-form">新增发件人 <i class="fas fa-user-plus"></i></button>
                    </div>
                </div>

            </div>
        </div>

        <slot></slot>
    </div>


</template>

<style>
    .nav-link {
        color: darkgrey
    }

    .nav-link.active {
        text-decoration: underline;
    }
</style>

<script>
    export default {
        data() {
            return {
                sending_addresses: [],
                sender_addresses: [],
                sending_address: {
                    id: '',
                    name: '',
                    phone: '',
                    province: '',
                    city: '',
                    suburb: '',
                    detail: ''
                },
                sender_address: {
                    id: '',
                    name: '',
                    detail: '',
                    phone: ''
                },
                province: '',
                city: '',
                suburb: '',
                detail: '',
                edit: 'false'
            }
        },
        created() {
            this.fetch_sending_addresses();
        },
        methods: {
            change_sending_edit(sending_address) {
                this.edit = 'true';
                this.sending_address.id = sending_address.id;
                this.sending_address.name = sending_address.name;
                this.sending_address.phone = sending_address.phone;
                this.detail = sending_address.detail;
                this.province = sending_address.province;
                this.city = sending_address.city;
                this.suburb = sending_address.suburb;
            },
            change_sending_new() {
                this.edit = 'false';
                this.sending_address = {};
            },
            change_sender_edit(sender_address) {
                this.edit = 'true';
                this.sender_address.id = sender_address.id;
                this.sender_address.name = sender_address.name;
                this.sender_address.detail = sender_address.detail;
                this.sender_address.phone = sender_address.phone;
            },
            change_sender_new() {
                this.edit = 'false';
                this.sender_address = {};
            },
            fetch_sending_addresses() {
                $.ajax({
                    url: 'get_sending_addresses',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.sending_addresses = data;
                });
            },
            update_sending_address() {
                $('#address-form').modal('toggle');
                this.sending_address.province = placesMap[this.sending_address.province + '0000'];
                this.sending_address.city = placesMap[this.sending_address.city + '00'];
                this.sending_address.suburb = placesMap[this.sending_address.suburb];

                var sending_data = this.sending_address;
                $.ajax({
                    url: 'addresses/new',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: sending_data,
                    dataType: 'json',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.fetch_sending_addresses();
                    if (data == "success") {
                        if (this.edit == 'true') {
                            alert("更新成功");
                        } else {
                            alert("添加成功");
                        }

                    } else {
                        alert("错误");
                    }
                });
            },
            delete_sending_address(id) {
                $.ajax({
                    url: 'delete_sending_address',
                    method: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'address_id': id
                    },
                    dataType: 'json',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.fetch_sending_addresses();
                    if (data == "success") {
                        alert("删除成功");
                    } else {
                        alert("删除失败");
                    }
                });
            },
            fetch_sender_addresses() {
                $.ajax({
                    url: 'get_sender_addresses',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.sender_addresses = data;
                });
            },
            update_sender_address() {
                $('#sender-address-form').modal('toggle');
                var sending_data = this.sender_address;
                $.ajax({
                    url: 'sender_addresses/new',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: sending_data,
                    dataType: 'json',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.fetch_sender_addresses();
                    if (data == "success") {
                        if (this.edit == 'true') {
                            alert("更新成功");
                        } else {
                            alert("添加成功");
                        }
                    } else {
                        alert("添加失败");
                    }
                });
            },
            delete_sender_address(id) {
                $.ajax({
                    url: 'delete_sender_address',
                    method: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'address_id': id
                    },
                    dataType: 'json',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.fetch_sender_addresses();
                    if (data == "success") {
                        alert("删除成功");
                    } else {
                        alert("删除失败");
                    }
                });
            }
        }

    }
</script>