<template>
    <div v-if="!loading">
        <feed v-for="feed in $root.modeData.feeds" :key="feed.id" :feed="feed"></feed>
    </div>
</template>

<script>
import Feed from '../components/Feed'

export default {
    data() {
        return {
            loading: true
        }
    },
    methods: {
        getData() {
            var app = this
            app.$root.loading = true

            axios.post('/v1/api/personal/get-base-data', {
                slug: app.$route.params.slug
            }).then(function (resp) {
                app.$root.modeData.links = resp.data.links
                app.$root.mode = resp.data.mode
                app.$root.loading = false
            }).catch(function (resp) {
                app.$root.loading = false
            })
        },
        getFeeds() {
            var app = this
            app.loading = true

            axios.post('/v1/api/personal/get-feeds', {
                slug: this.$route.params.slug
            }).then(function (resp) {
                app.$root.modeData.feeds = resp.data.feeds
                app.loading = false
            }).catch(function (resp) {
                // app.$root.store.setMessageAction("Could not load rows", 'danger')
                app.loading = false
            })
        }
    },
    mounted() {
        this.getData()
        this.getFeeds()
    },
    components: {
        Feed
    }
}
</script>

