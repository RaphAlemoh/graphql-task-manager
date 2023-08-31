import loadash from 'lodash'
window._ = loadash

import * as Popper from '@popperjs/core'
window.Popper = Popper


import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;


import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


window.axios.defaults.headers.common["Content-Type"] = "application/json";
window.axios.defaults.headers.common["Accept"] = "application/json";

let user_token = window.localStorage.getItem("token");
if (user_token) {
    window.axios.defaults.headers.common["Authorization"] = "Bearer " + user_token;
}


