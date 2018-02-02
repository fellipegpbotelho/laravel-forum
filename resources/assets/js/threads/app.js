window.Vue = require('vue');

Vue.component('threads', require('./components/Threads.vue'));

const app = new Vue({
    el: '#app'
});
