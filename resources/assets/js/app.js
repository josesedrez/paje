import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);

Vue.component('about', require('./components/About.vue'));
Vue.component('home', require('./components/Home.vue'));

let app = new Vue({
    el: '#app',

    router: new VueRouter(routes)
});
