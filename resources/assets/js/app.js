
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('plataformas', require('./components/Plataforma.vue'));
Vue.component('generos', require('./components/Genero.vue'));
Vue.component('inicio', require('./components/Inicio.vue'));
Vue.component('productos', require('./components/Producto.vue'));
Vue.component('clientes', require('./components/Cliente.vue'));
Vue.component('usuarios', require('./components/Usuario.vue'));
Vue.component('socios', require('./components/Socio.vue'));
Vue.component('transacciones', require('./components/Transaccion.vue'));

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)



const app = new Vue({
    el: '#app',
    data:{
        menu:0
    }
});
