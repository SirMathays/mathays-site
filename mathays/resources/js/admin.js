
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
import moment from 'moment-timezone'
Vue.use(VueMoment, {
    moment
})

import store from './store'
import Toaster from './components/Toaster'

const app = new Vue({
    el: '#admin',
    router: new VueRouter(router),
    data() {
        return {
            store,
            loading: true,
            coreLoading: true,

            user: [],
            quote: '',
            siteName: '',
            photo: undefined,
        }
    },
    watch: {
        $route(to, from) {
            if (from.name != to.name) this.loading = true
        }
    },
    computed: {
        // 
    },
    methods: {
        getUser() {
            var app = this

            axios.get('/v1/api/admin/get-user')
                .then(function (resp) {
                    app.user = resp.data.user
                    app.photo = resp.data.bing.url
                    app.quote = resp.data.quote
                    app.siteName = resp.data.siteName
                    app.coreLoading = false
                }).catch(function (resp) {
                    app.store.setMessageAction(resp.response.data.message, 'danger')
                    app.coreLoading = false
                })
        }
    },
    mounted() {
        this.getUser()
    },
    components: {
        Toaster
    }
})