<template>
    <div class="component" v-if="!$root.loading">
        <h1>Newest post</h1>
        <router-link :to="{ name: 'post', params: {slug: newest.slug}}" v-if="newest" class="card video-card mb-4">
            <div class="bottom-fade"></div>
            <div class="card-body video-child">
                <h4 class="card-title">{{ newest.title }}</h4>
                <h6 class="card-subtitle mb-2 text-muted">{{ newest.created_at | moment('calendar') }}</h6>
                <div v-html="newest.body"></div>
            </div>
        </router-link>

        <h2>Previous posts</h2>
        <b-card class="post-list mb-4">
            <template v-for="(group, groupIndex) in blogposts">
                <p class="post-group-title" :key="groupIndex">{{ [groupIndex, 'YYYY-MM'] | moment("MMM YYYY") }}</p>
                <router-link :to="{name: 'post', params: {slug: blogpost.slug}}" class="post-row" v-for="blogpost in group" :key="blogpost.id">
                    <span class="post-row-title">{{ blogpost.title }}</span>
                    <span class="post-row-date">{{ blogpost.created_at | moment("calendar") }}</span>
                </router-link>
            </template>
        </b-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            blogposts: [],
            newest: undefined
        }
    },
    methods: {
        linkTo(e, slug) {
            e.preventDefault()
            this.$router.push({ name: 'post', params: { slug: slug }})
        },
        getBlogposts() {
            var app = this

            axios.get('/v1/api/get-blog')
            .then(function (resp) {
                app.blogposts = resp.data.blogposts
                app.newest = resp.data.newest
                app.$root.loading = false
            }).catch(function (resp) {
                alert("Could not load rows")
                app.$root.loading = false
            })
        }
    },
    mounted() {
        this.getBlogposts()
    }
}
</script>