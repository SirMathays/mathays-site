<template>
    <div class="component" v-if="!$root.loading">
        <b-container>
            <article class="mt-5 mb-4" v-if="post">
                <div class="post-header">
                    <h1 class="h4">{{ post.title }}</h1>
                    <h2 class="h6 text-muted">{{ post.created_at | moment('calendar') }}</h2>
                </div>
                <div class="mt-3" v-html="post.body"></div>
            </article> 
        </b-container>        
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
                year: this.$route.params.year,
                month: this.$route.params.month,
                slug: this.$route.params.slug
            }).then(function (resp) {
                app.post = resp.data.post
                app.$root.loading = false
            }).catch(function (resp) {
                app.$router.push({name: 'not-found'})
            })
        }
    },
    mounted() {
        this.getPost()
    }
}
</script>