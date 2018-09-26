<template>
    <b-container v-if="!$root.loading">
        <b-jumbotron header="Hello, Matti!" lead="Let's create something!">
            <p v-if="video">Last video published {{ video.published_at | moment("from", "now") }}!</p>
            <p v-else>No video published! Go and publish one!</p>
            <p v-if="blogpost">Last blog post published {{ blogpost.published_at | moment("from", "now") }}!</p>
            <p v-else>No blog post published! Go and publish one!</p>
        </b-jumbotron>

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
                alert("Could not load rows")
                app.$root.loading = false
            })
        }
    },
    mounted() {
        this.getDashboardMaterial()
    }
}
</script>
