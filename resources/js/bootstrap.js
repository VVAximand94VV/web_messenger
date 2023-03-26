import _ from 'lodash';
window._ = _;

import 'bootstrap';
import router from "./router";

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;


// if error
// window.axios.interceptors.response.use({}, error => {
//     if(error.response.status === 401 || error.response.status === 419){
//         const TOKEN = localStorage.getItem('X-XSRF-TOKEN');
//         if(TOKEN){
//             localStorage.removeItem('X-XSRF-TOKEN');
//         }
//         router.push({name:'account.signin'});
//     }
// });

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"
//
// import Pusher from 'pusher-js';
// window.Pusher = Pusher;
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     //wsHost: window.location.hostname,
//     wsPort: 6001,
//     //disableStats: true,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
//     cluster:import.meta.env.VITE_PUSHER_APP_CLUSTER
// });

import Echo from "laravel-echo"

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    cluster:import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
    auth: {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
        },
    },
});

// window.Echo.channel('Inventory').listen('InventoryEvent',(e)=>{
//     console.log(e)
// })
