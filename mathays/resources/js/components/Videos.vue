<template>
    <div class="component" v-if="!$root.loading">
        <h1>Newest video</h1>
        <b-card v-if="newest" overlay
            :img-src="thumbnail(newest)"
            :img-alt="newest.title"
            text-variant="white"
            :title="newest.title"
            tag="a"
            href="#"
            @click="e => linkTo(e, newest.yid)"
            class="mb-5">
        </b-card>

        <h2>Videos</h2>
        <b-card-group class="card-grid gr-3 mb-4">
            <b-card v-if="videos.length > 0" v-for="(video, index) in videos" :key="index"
                img-top
                :img-src="thumbnail(video)"
                :img-alt="video.title"
                :title="video.title"
                tag="a"
                href="#"
                @click="e => linkTo(e, video.yid)">
            </b-card>
        </b-card-group>   
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