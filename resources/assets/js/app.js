
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('products',require('./components/Products.vue'));
Vue.component('categories',require('./components/Categories.vue'));
Vue.component('brands',require('./components/Brands.vue'));
Vue.component('shopping-cart',require('./components/ShoppingCart.vue'));
Vue.component('addresses', require('./components/Addresses.vue'));
Vue.component('orders',require('./components/Orders.vue'));
Vue.component('order',require('./components/Order.vue'));
Vue.component('order-self',require('./components/OrderSelf'));
Vue.component('product',require('./components/Product.vue'));
Vue.component('favourites',require('./components/Favourites.vue'));
Vue.component('products-list',require('./components/ProductsList.vue'));

/**
 * Components for staff
 */
Vue.component('staff-retail-index',require('./components/staff/retail/index.vue'));
Vue.component('StaffHome',require('./components/staff/retail/home.vue'));
Vue.component('StaffOrderShow',require('./components/staff/retail/show.vue'));
Vue.component('staff-package',require('./components/staff/retail/package.vue'));

/**
 * Vue routes
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

import StaffOrder from './components/staff/retail/show.vue'
import StaffHome from './components/staff/retail/home.vue'


Vue.use(VueRouter);

export const routes = [
    { path: '/daigou/staff/order/:id', component: StaffOrder, name: 'StaffOrder', props: true},
    { path: '/daigou/staff/home/:all_orders?', component: StaffHome, name: 'StaffHome', props: true}
]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router
});
