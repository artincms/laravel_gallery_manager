window.Vue = require('vue');
Vue.component('laravel_slider_system', require('./components/laravel_gallery_system/laravel_slider_system.vue'));
window.onload = function () {
    const slider = new Vue({
        el: '#slider',
    });
}