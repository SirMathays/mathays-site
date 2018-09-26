<template>
    <div class="component" v-if="!$root.loading">
        <v-container class="py-3 mb-5" :url="thumbnail(newest)" v-if="newest">
            <router-link :to="{ name: 'video', params: {id: newest.yid}}" class="card video-card">
                <img class="video-child" :src="thumbnail(newest)" :alt="newest.title">
                <div class="overlay-text">
                    <div class="text-container text-center">
                        <h2>NEWEST VIDEO</h2>
                        <h4>{{ newest.title }}</h4>
                    </div>
                </div>
            </router-link>
        </v-container>

        <b-container>
            <b-card-group class="card-grid gr-3 mb-4">
                <b-card v-if="videos.length > 0" v-for="(video, index) in videos" :key="index" 
                    no-body
                    :img-src="thumbnail(video)"
                    :img-alt="video.title"
                    tag="a"
                    href="#"
                    @click="e => linkTo(e, video.yid)">
                    <div class="video-title">{{ video.title }}</div>
                </b-card>
            </b-card-group>   
        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            videos: [],
            newest: undefined
        }
    },
    methods: {
        linkTo(e, yid) {
            e.preventDefault()
            this.$router.push({ name: 'video', params: { id: yid }})
        },
        thumbnail(item) {
            if(item)
                return 'https://img.youtube.com/vi/'+item.yid+'/maxresdefault.jpg'
        },
        getVideos() {
            var app = this

            axios.get('/v1/api/get-videos')
            .then(function (resp) {
                app.videos = resp.data.videos
                app.newest = resp.data.newest
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