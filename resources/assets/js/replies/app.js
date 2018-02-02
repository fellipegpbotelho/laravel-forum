window.Vue = require('vue');

Vue.component('replies', require('./components/Replies.vue'));

const app = new Vue({
    el: '#app'
});
