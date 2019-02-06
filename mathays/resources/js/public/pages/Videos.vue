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
            <paginate name="videos" tag="b-card-group" class="card-grid gr-3 mb-4" :list="videos.rows" :per="videos.per">
                <b-card 
                    v-for="(video, index) in paginated('videos')"
                    :key="index"
                    no-body
                    :img-src="thumbnail(video)"
                    :img-alt="video.title"
                    tag="a"
                    href="#"
                    @click="e => linkTo(e, video.yid)">
                    <div class="video-title">{{ video.title }}</div>
                </b-card>
            </paginate>

            <paginate-links 
                for="videos" 
                :hide-single-page="true" 
                :showStepLinks="true" 
                :stepLinks="{ prev: '‹', next: '›' }"
            />
        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            paginate: ['videos'],
            videos: {
                filter: undefined,
                rows: [],
                per: 10
            },
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
                app.videos.rows = resp.data.videos
                app.newest = resp.data.newest
                app.$root.loading = false
            }).catch(function (resp) {
                app.$root.store.setMessageAction("Could not load rows", 'danger')
                app.$root.loading = false
            })
        }
    },
    mounted() {
        this.getVideos()
    }
}
</script>