
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

import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate)

Vue.component('v-container', require('./public/components/VideoContainer.vue'))

const app = new Vue({
    el: '#app',
    router: new VueRouter(router),
    data() {
        return {
            loading: true,
        }
    },
    watch: {
        $route(to, from) {
            if(from != to) this.loading = true
        }
    },
    computed: {
        homeActive() {
            return this.$route.name == 'home'
        }
    }
})
