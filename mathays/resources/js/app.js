
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
import moment from 'moment-timezone'
Vue.use(VueMoment, {
    moment
})

import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate)

Vue.component('v-container', require('./public/components/VideoContainer.vue'))

import store from './store'
import Toaster from './components/Toaster'

const app = new Vue({
    el: '#app',
    router: new VueRouter(router),
    data() {
        return {
            store,
            loading: true,
            tz: this.$moment.tz.guess()
        }
    },
    mounted() {
        document.cookie = "mathays_tz=" + this.$moment.tz.guess();
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
    },
    components: {
        Toaster
    }
})
