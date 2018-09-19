<template>
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-2 col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4 justify-content-center mb-3 p-0"
                 v-for="brand in brands" v-bind:key="brand.id">
                <div v-on:click="show_brand(brand.id)">
                    <img v-if="brand.img_url" class="mx-auto d-block brand-img"
                         v-bind:src="'/daigou/storage/app/'+brand.img_url" alt="暂无图片">
                    <div v-else class="card-header text-center"><span class="align-middle small">{{brand.name}}</span></div>
                </div>
            </div>


        </div>
        <div v-if="other_brands.length == 0" class="row">
            <div class="col-2 col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4 justify-content-center mb-3 p-0 offset-4">
                <img v-bind:src="'/daigou/storage/app/assets/category_img_morebrands_default_2@2x.png'" v-on:click="fetch_all_brands" class="mx-auto d-block brand-img">
            </div>
        </div>
        <div class="row">
            <div class="col-2 col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4 justify-content-center mb-3"
                 v-for="brand in other_brands" v-bind:key="brand.id">
                <div v-if="brand.img_url" v-on:click="show_brand(brand.id)">
                    <img v-if="brand.img_url" class="mx-auto d-block brand-img"
                         v-bind:src="'/daigou/storage/app/'+brand.img_url" alt="暂无图片">
                    <div v-else class="card-header text-center"><span class="align-middle small">{{brand.name}}</span></div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .brand-img {
        width: 30vw;
        height: 30vw;
    }
</style>

<script>
    export default {
        props: ['brandsData'],
        data() {
            return {
                brands: [],
                other_brands: [],
                brand: {
                    id: '',
                    name: '',
                    img_url: ''
                }
            }
        },
        mounted() {
            this.brands = JSON.parse(this.brandsData);
        },
        methods: {
            show_brand(id) {
                window.location.href = "/daigou/mall/brands/" + id;
            },
            fetch_all_brands() {
                $.ajax({
                    url: 'get_other_brands',
                    method: 'GET',
                    success: function (response) {
                    },
                    error: function (error) {
                        alert("操作失败");
                        console.log(error);
                    }
                }).done(data => {
                    this.other_brands = data;
                });
            }
        }
    }
</script>