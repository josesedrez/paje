import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

import 'v-slim-dialog/dist/v-slim-dialog.css';
import SlimDialog from 'v-slim-dialog';

import { VueCrypton } from 'laravel-crypton';

Vue.use(SlimDialog);

Vue.use(VueRouter);

const key = 'base64:egGf2oTpKV5EYrRFv8gm6wJAf8mQP4gZ0tAdtDoGWJ4='; // env('CRYPTON_KEY')
Vue.use(VueCrypton(key), {
    // Any Axios Options
});

let app = new Vue({
    el: '#app',

    router: new VueRouter(routes)
});
