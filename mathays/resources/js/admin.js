
require('./bootstrap')

window.Vue = require('vue')

// VUE ROUTER
import VueRouter from 'vue-router'
window.Vue.use(VueRouter)
import router from './public/router'

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import VueYouTubeEmbed from 'vue-youtube-embed'
Vue.use(VueYouTubeEmbed)

import VueMoment from 'vue-moment'
Vue.use(VueMoment)

import Vue2Editor from 'vue2-editor'
Vue.use(Vue2Editor)

const app = new Vue({
    el: '#admin',
    router: new VueRouter(router),
    data() {
        return {
            loading: false
        }
    },
    computed: {
        // 
    }
})