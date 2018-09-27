<template>
    <div class="component" v-if="!$root.loading">
        <v-container class="py-3 mb-5" :url="thumbnail(video)" v-if="video">
            <router-link :to="{ name: 'video', params: {id: video.yid}}" class="card video-card">
                <img class="video-child" :src="thumbnail(video)" :alt="video.title">
                <div class="overlay-text">
                    <div class="text-container text-center">
                        <h2>NEWEST VIDEO</h2>
                        <h4>{{ video.title }}</h4>
                    </div>
                </div>
            </router-link>
        </v-container>

        <b-container class="my-5">
            <h1 class="page-title">Mathays Productions</h1>
            <h2 class="h3 page-description text-center">{{ story }}</h2>
        </b-container>

        <b-container class="text-center">
            <b-btn :to="{ name: 'blog' }" size="lg" variant="outline-dark" block class="my-0">Read my blog</b-btn>
        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            video: undefined,
            blogpost: undefined,
            people: [],
            story: undefined,
        }
    },
    methods: {
        thumbnail(item) {
            if(item)
                return 'https://img.youtube.com/vi/'+item.yid+'/maxresdefault.jpg'
        },
        getVideos() {
            var app = this

            axios.get('/v1/api/get-home-material')
            .then(function (resp) {
                app.video = resp.data.video
                app.blogpost = resp.data.blogpost
                app.story = resp.data.story
                app.people = resp.data.people
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