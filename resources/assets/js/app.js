
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Slug = require('slug');
Slug.defaults.mode = 'rfc3986';
window.toastr = require('toastr');

window.$ = window.SlimScroll = require('jquery-slimscroll');

window.$ = window.fastselect = require('fastselect');

require('./common.js');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('my-component', require('./components/modal.vue'));

/*import VoerroTagsInput from '@voerro/vue-tagsinput';

Vue.component('tags-input', VoerroTagsInput);*/

/*Vue.component('notas', require('./components/Notas.vue'));*/







