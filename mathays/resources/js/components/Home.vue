<template>
    <div class="component" v-if="!$root.loading">
        <h1 class="page-title">Mathays Productions</h1>
        <h2 class="h3 page-description text-center">{{ story }}</h2>
        
        <b-card-group class="my-4 card-grid gr-2">
            <router-link :to="{ name: 'video', params: {id: video.yid}}" v-if="video" class="card video-card">
                <img class="video-child" :src="thumbnail(video)" :alt="video.title">
            </router-link>

            <router-link :to="{ name: 'post', params: {slug: blogpost.slug}}" v-if="blogpost" class="card video-card">
                <div class="bottom-fade"></div>
                <div class="card-body video-child">
                    <h4 class="card-title">{{ blogpost.title }}</h4>
                    <div v-html="blogpost.body"></div>
                </div>
            </router-link>
        </b-card-group>
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