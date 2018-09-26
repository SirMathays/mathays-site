
require('./bootstrap')

window.Vue = require('vue')

// VUE ROUTER
import VueRouter from 'vue-router'
window.Vue.use(VueRouter)
import router from './admin/router'

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import VueYouTubeEmbed from 'vue-youtube-embed'
Vue.use(VueYouTubeEmbed)

import VueMoment from 'vue-moment'
Vue.use(VueMoment)

const app = new Vue({
    el: '#admin',
    router: new VueRouter(router),
    data() {
        return {
            loading: true
        }
    },
    watch: {
        $route(to, from) {
            if (from.name != to.name) this.loading = true
        }
    },
    computed: {
        // 
    }
})