/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('add-client-component', require('./components/AddClientComponent.vue').default);
Vue.component('clients-component', require('./components/ClientsComponent.vue').default);
Vue.component('card-client-component', require('./components/CardClientComponent.vue').default);
Vue.component('tiket-component', require('./components/TiketComponent.vue').default);
Vue.component('form-add-tiket-component', require('./components/FormAddTiketComponent.vue').default);
Vue.component('client-detail-component', require('./components/ClientDetailComponent.vue').default);
Vue.component('all-tiket-detail-modal', require('./components/AllTiketDetailModalComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});