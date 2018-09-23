<template>
    <div class="component" v-if="!$root.loading">
        <b-container>
            <h1 class="page-title">Mathays Productions</h1>
            <h2 class="h3 page-description text-center">{{ story }}</h2>
        </b-container>
            
        <!-- <b-card-group class="my-4 card-grid gr-2"> -->
        <b-row no-gutters class=" justify-content-center splash my-5 py-4" v-if="video">
            <b-col cols="11" sm="8" md="6">
                <router-link :to="{ name: 'video', params: {id: video.yid}}" class="card video-card">
                    <img class="video-child" :src="thumbnail(video)" :alt="video.title">
                    <div class="overlay-text">
                        <h2>NEW VIDEO</h2>
                        <h4>{{ video.title }}</h4>
                    </div>
                </router-link>
            </b-col>
        </b-row>

        <b-container class="text-center">
            <b-btn :to="{ name: 'blog' }" size="lg" variant="outline-dark" block class="my-0">Read blog</b-btn>
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