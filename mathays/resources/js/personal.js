
require('./bootstrap')

window.Vue = require('vue')

// VUE ROUTER
import VueRouter from 'vue-router'
window.Vue.use(VueRouter)
import router from './personal/router'

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
Vue.use(VueMoment, {
    moment
})

import draggable from 'vuedraggable'

import store from './store'
import Toaster from './components/Toaster'
import Modes from './personal/components/Modes'

Vue.component('v-style', {
    render: function (createElement) {
        return createElement('style', this.$slots.default)
    }
});

const app = new Vue({
    el: '#personal',
    router: new VueRouter(router),
    data() {
        return {
            store,
            loading: true,
            mode: undefined,
            modes: {},
            now: this.$moment(),

            modeData: {
                links: [],
                feeds: {},
            }
        }
    },
    watch: {
        $route(to, from) {
            if (from != to) {
                this.loading = true
                this.modeData.links = []
            }
        },
    },
    methods: {
        getModes() {
            var app = this

            axios.post('/v1/api/personal/get-modes', {
                slug: this.$route.params.slug
            }).then(function (resp) {
                app.modes = resp.data.modes
                app.loading = false
            }).catch(function (resp) {
                // app.$root.store.setMessageAction("Could not load rows", 'danger')
                app.loading = false
            })
        }
    },
    created() {
        setInterval(() => this.now = this.$moment(), 1000)
        this.getModes()
    },
    components: {
        Modes,
        Toaster,
        draggable
    }
})