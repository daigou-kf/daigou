<template>
    <div id="index">
        <div v-on:click="to_index()" id="heading" class="container p-0 text-light text-center">
            <h3 class="v-c-text">订单明细</h3>
        </div>

        <router-view>

        </router-view>



    </div>
</template>
<style>
    #heading {
        height: 8vh;
        background-image: linear-gradient(to right, #463292, #62acdf);
    }

    .v-c-text {
        position: relative;
        left: 50vw;
        top: 4vh;
        transform: translateX(-50%) translateY(-50%);
    }
</style>
<script>
    export default {
        data(){
            return {
                all_orders: [
                    {
                        id: "7373852480",
                        status: 1,
                        package_method: "self",
                        sender: {
                            name: "Paul",
                            phone: "0421884740",
                            address: "6 Hope Street"
                        },
                        packages: [
                            {
                                company: {
                                    name: "4px",
                                    alias: "四方转运"
                                },
                                sending: {
                                    name: "Amber",
                                    phone: "0410777777",
                                    address: "详细地址"
                                },
                                products: [
                                    {
                                        id: 1,
                                        name: "奶粉2段",
                                        spec: "300g",
                                        quantity: 4
                                    },
                                    {
                                        id: 2,
                                        name: "护肝片",
                                        spec: "100粒",
                                        quantity: 2
                                    }
                                ],
                                status: 0
                            },
                            {
                                company: {
                                    name: "lantian",
                                    alias: "蓝天"
                                },
                                sending: {
                                    name: "Tony",
                                    phone: "0430777777",
                                    address: "详细地址"
                                },
                                products: [
                                    {
                                        id: 1,
                                        name: "奶粉2段",
                                        spec: "300g",
                                        quantity: 2
                                    },
                                    {
                                        id: 2,
                                        name: "护肝片",
                                        spec: "100粒",
                                        quantity: 5
                                    }
                                ],
                                status: 0
                            }
                        ]
                    },
                    {
                        id: "2333065216",
                        status: 1,
                        package_method: "auto",
                        sender: {
                            name: "James",
                            phone: "0457778888",
                            address: "6 Hope Street"
                        },
                        sending: {
                            name: "Tony",
                            phone: "0430777777",
                            address: "详细地址"
                        },
                        products: [
                            {
                                id: 1,
                                name: "奶粉2段",
                                spec: "300g",
                                num: 8
                            },
                            {
                                id: 2,
                                name: "护肝片",
                                spec: "100粒",
                                num: 10
                            }
                        ],
                        packages: []
                    },
                    {
                        id: "4407055427",
                        status: 2,
                        package_method: "auto",
                        sender: {
                            name: "Oscar",
                            phone: "0457888777",
                            address: "6 Hope Street"
                        },
                        sending: {
                            name: "Tony",
                            phone: "0430777777",
                            address: "详细地址"
                        },
                        packages: [
                            {
                                company: {
                                    name: "4px",
                                    alias: "四方转运"
                                },
                                sending: {
                                    name: "Amber",
                                    phone: "0410777777",
                                    address: "详细地址"
                                },
                                products: [
                                    {
                                        id: 1,
                                        name: "奶粉2段",
                                        spec: "300g",
                                        quantity: 4
                                    },
                                    {
                                        id: 2,
                                        name: "护肝片",
                                        spec: "100粒",
                                        quantity: 2
                                    }
                                ],
                                status: 1
                            },
                            {
                                company: {
                                    name: "lantian",
                                    alias: "蓝天"
                                },
                                sending: {
                                    name: "Tony",
                                    phone: "0430777777",
                                    address: "详细地址"
                                },
                                products: [
                                    {
                                        id: 1,
                                        name: "奶粉2段",
                                        spec: "300g",
                                        quantity: 2
                                    },
                                    {
                                        id: 2,
                                        name: "护肝片",
                                        spec: "200粒",
                                        quantity: 5
                                    }
                                ],
                                status: 1
                            }
                        ]
                    }
                ]
            }
        },
        created(){
            this.$router.push({name: 'StaffHome'});
        },
        methods: {
            to_index(){
                this.$router.push({name: 'StaffHome'});
            }
        }
    }

</script>