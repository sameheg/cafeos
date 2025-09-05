
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./dashboard');

import Vue from 'vue'
import { syncQueuedSales } from './pos/offlineStorage';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component('theme-preview', require('./components/ThemePreview.vue').default);

const app = new Vue({
    el: '#app'
});

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js');
    });
}

const indicator = document.getElementById('network-indicator');
function updateStatus() {
    if (!indicator) return;
    if (navigator.onLine) {
        indicator.textContent = 'Online';
        indicator.classList.remove('offline');
        indicator.classList.add('online');
        syncQueuedSales();
    } else {
        indicator.textContent = 'Offline';
        indicator.classList.remove('online');
        indicator.classList.add('offline');
    }
}

window.addEventListener('online', updateStatus);
window.addEventListener('offline', updateStatus);
updateStatus();
