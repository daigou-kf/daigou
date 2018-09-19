<template>
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4 justify-content-center mb-3" v-for="category in categories" v-bind:key="category.id">
                <div v-on:click="show_category(category.id)" class="card">
                    <img v-if="category.img_url" class="cate-img card-img img-thumbnail mx-auto d-block" v-bind:src="'/daigou/storage/app/'+category.img_url" alt="暂无图片">
                    <div class="card-header text-center small p-1"><span class="align-middle">{{category.name}}</span></div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props: ['categoriesData'],
        data(){
            return {
                categories: [],
                category: {
                    id: '',
                    name: '',
                    img_url: ''
                }
            }
        },
        mounted(){
            this.categories = JSON.parse(this.categoriesData);
        },
        methods: {
            show_category(id){
                window.location.href = "categories/"+id;
            }
        }
    }
</script>