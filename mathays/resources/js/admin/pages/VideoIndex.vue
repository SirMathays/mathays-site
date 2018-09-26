<template>
    <b-container v-if="!$root.loading">
        <b-card class="my-4">
            <h4>Unpublished videos</h4>
            <router-link class="post-row" v-for="video in unpublished" :key="video.id" :to="{name: 'video-edit', params: {id: video.id}}">
                <span class="post-row-title">{{ video.title }}</span>
                <span class="post-row-date">Last edited: {{ video.updated_at | moment('calendar') }}</span>
            </router-link>
            <p v-if="unpublished.length <= 0">No unpublished videos</p>
        </b-card>

        <b-btn :to="{ name: 'video-edit' }" size="lg" variant="primary" block class="my-4">Publish a video</b-btn>

        <b-card>
            <h4>Published</h4>
            <router-link class="post-row" v-for="video in published" :key="video.id" :to="{name: 'video-edit', params: {id: video.id}}">
                <span class="post-row-title">{{ video.title }}</span>
                <span class="post-row-date">{{ video.published_at | moment('calendar') }}</span>
            </router-link>
        </b-card>
    </b-container>
</template>

<script>
export default {
    data() {
        return {
            videos: [],
        }
    },
    computed: {
        unpublished() {
            return this.videos.filter((video, key) => {
                return video.published_at == null
            })
        },
        published() {
            return this.videos.filter((video, key) => {
                return video.published_at != null
            })
        }
    },
    methods: {
        getVideos() {
            var app = this

            axios.get('/v1/api/admin/video-index')
            .then(function (resp) {
                app.videos = resp.data.videos
                app.$root.loading = false
            }).catch(function (resp) {
                alert("Could not load rows")
                app.$root.loading = false
            })
        }
    },
    mounted() {
        this.getVideos()
    }
}
</script>