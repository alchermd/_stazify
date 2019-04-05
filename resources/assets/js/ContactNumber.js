window.Vue = require('vue');

Vue.component('contact-number', require('./components/ContactNumber.vue'));

const app = new Vue({
    el: '#app',
});
