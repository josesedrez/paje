import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

import 'v-slim-dialog/dist/v-slim-dialog.css';
import SlimDialog from 'v-slim-dialog';

Vue.use(SlimDialog);

Vue.use(VueRouter);

let app = new Vue({
    el: '#app',

    router: new VueRouter(routes)
});
