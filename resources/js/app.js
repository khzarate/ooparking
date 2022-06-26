/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { createApp, h } from "vue";
import { App as InertiaApp, plugin as InertiaPlugin, } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from '@inertiajs/progress';


window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const el = document.getElementById("app");

 createApp({
     render: () =>
         h(InertiaApp, {
             initialPage: JSON.parse(el.dataset.page),
             resolveComponent: (name) => require(`./Pages/${name}`).default,
         }),
 }).mixin({ methods: { route } })
    .use(InertiaPlugin)
    .mount(el);
 
 InertiaProgress.init({ color: '#0C4D9A' });
