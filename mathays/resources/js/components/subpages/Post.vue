<template>
    <div class="component" v-if="!$root.loading">
        <b-card tag="article" class="mb-4" :title="post.title" :subTitle="post.created_at | moment('calendar')">
            <div class="mt-3" v-html="post.body"></div>
        </b-card> 
    </div>
</template>

<script>
export default {
    data() {
        return {
            post: [],
        }
    },
    methods: {
        getPost() {
            var app = this

            axios.post('/v1/api/get-post', {
                slug: this.$route.params.slug
            }).then(function (resp) {
                app.post = resp.data.post
                app.$root.loading = false
            }).catch(function (resp) {
                alert("Could not load video")
                app.$root.loading = false
            })
        }
    },
    mounted() {
        this.getPost()
    }
}
</script>