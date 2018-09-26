
require('./bootstrap')

window.Vue = require('vue')

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import VueYouTubeEmbed from 'vue-youtube-embed'
Vue.use(VueYouTubeEmbed)

import VueMoment from 'vue-moment'
Vue.use(VueMoment)

const app = new Vue({
    el: '#app',
    data() {
        return {
            loading: false
        }
    },
    computed: {
        indexActive() {
            return this.$route.name == 'index'
        }
    }
})