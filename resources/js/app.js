
window.Vue = require('vue').default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('nav-component', require('./components/Nav.vue').default);
Vue.component('headear-component', require('./components/Nav.vue').default);
Vue.component('footer-component', require('./components/Nav.vue').default);
Vue.component('body-component', require('./components/Nav.vue').default);
Vue.component('main-component', require('./components/Nav.vue').default);
Vue.component('content-component', require('./components/Nav.vue').default);
Vue.component('tooltip-component', require('./components/Nav.vue').default);
Vue.component('alert-component', require('./components/Nav.vue').default);
Vue.component('imagenes-component', require('./components/Nav.vue').default);



const app = new Vue({
    el: '#app',
});
