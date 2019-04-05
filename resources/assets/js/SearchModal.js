window.Vue = require('vue');

Vue.component('search-modal', require('./components/SearchModal.vue'));

new Vue({
    el: '#searchModalRoot',
});
