<template>
    <b-container v-if="!$root.loading">
        <transition name="slide-ver">
            <div class="jumbotron dashboard" :style="background" v-if="!$root.coreLoading" :class="{'text-white': background}">
                <h1 class="display-3" v-html="'Hello, ' + $root.user.first_name + '!'"></h1>
                <p class="lead">{{ $root.quote }}</p>

                <p v-if="video">Last video published {{ video.published_at_tz | moment("from", "now") }}!</p>
                <p v-else>No video published! Go and publish one!</p>
                <p v-if="blogpost">Last blog post published {{ blogpost.published_at_tz | moment("from", "now") }}!</p>
                <p v-else>No blog post published! Go and publish one!</p>
            </div>
        </transition>

        <b-btn :to="{ name: 'video-edit' }" size="lg" variant="primary" block class="my-4">Publish a video</b-btn>
        <b-btn :to="{ name: 'post-edit' }" size="lg" variant="outline-dark" block class="my-4">Write a blog post</b-btn>
    </b-container>
</template>

<script>
export default {
    data() {
        return {
            video: undefined,
            blogpost: undefined,
        }
    },
    methods: {
        getDashboardMaterial() {
            var app = this

            axios.get('/v1/api/admin/get-dashboard-material')
            .then(function (resp) {
                app.video = resp.data.video
                app.blogpost = resp.data.blogpost
                app.$root.loading = false
            }).catch(function (resp) {
                app.$root.loading = false
            })
        }
    },
    computed: {
        background() {
            return this.$root.photo ? "background-image: linear-gradient(to right, rgba(0,0,0,0.8), transparent), url('" + this.$root.photo + "')" : undefined
        }
    },
    mounted() {
        this.getDashboardMaterial()
    }
}
</script>
