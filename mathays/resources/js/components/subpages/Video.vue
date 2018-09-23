<template>
    <div class="component" v-if="!$root.loading">
        <b-container>
            <b-card class="video-card bg-dark mb-4" no-body>
                <youtube 
                    :video-id="video.yid"
                    player-width="100%"
                    player-height="100%"
                    ref="youtube"
                    class="video-child"></youtube>
            </b-card>

            <article class="mt-4 mb-4">
                <h1 class="h4">{{ video.title }}</h1>
                <h2 class="h6 text-muted">{{ video.published_at | moment('calendar') }}</h2>
                <div class="article-links mt-4 mb-3" v-if="video.blog_post">
                    <a href="#" :class="show == 'description' && 'active'" @click="e => toggleShow(e, 'description')">Description</a>
                    <a href="#" :class="show == 'story' && 'active'" @click="e => toggleShow(e, 'story')">Story</a>
                </div>
                <transition name="slide-hor" mode="out-in">
                    <div :key="1" v-if="show == 'description'" v-html="video.description || 'No description'"></div>
                    <div :key="2" v-else-if="show == 'story'">
                        <h4>{{ video.blog_post.title }}</h4>
                        <div v-html="video.blog_post.body"></div>
                    </div>
                </transition>
            </article>
        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            video: [],
            show: 'description'
        }
    },
    watch: {
        show: function(newValue, oldValue) {
            if(newValue == 'story' && !this.video.blog_post) this.show = 'description'
        }
    },
    methods: {
        thumbnail(item) {
            if(item)
                return 'https://img.youtube.com/vi/'+item.yid+'/maxresdefault.jpg'
        },
        toggleShow(e, value) {
            e.preventDefault()
            this.show = value
        },
        getVideo() {
            var app = this

            axios.post('/v1/api/get-video', {
                yid: this.$route.params.id
            }).then(function (resp) {
                app.video = resp.data.video
                app.$root.loading = false
            }).catch(function (resp) {
                app.$router.push({name: 'not-found'})
            })
        }
    },
    mounted() {
        this.getVideo()
    }
}
</script>
