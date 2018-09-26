<template>
    <div class="component" v-if="!$root.loading">
        <b-container>
            <h2 class="mt-4">newest post</h2>
            <router-link :to="{ name: 'post', params: {year: newest.pub_year, month: newest.pub_month, slug: newest.slug}}" v-if="newest" class="card video-card mb-5">
                <div class="bottom-fade"></div>
                <div class="card-body video-child">
                    <h4 class="card-title">{{ newest.title }}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">{{ newest.published_at | moment('calendar') }}</h6>
                    <div v-html="newest.body"></div>
                </div>
            </router-link>
        </b-container>
        
        <b-container>
            <h2>previous posts</h2>
            <b-card class="post-list mb-4">
                <template v-for="(group, groupIndex) in blogposts">
                    <p class="post-group-title" :key="groupIndex">{{ [groupIndex, 'YYYY-MM'] | moment("MMM YYYY") }}</p>
                    <router-link :to="{name: 'post', params: {year: blogpost.pub_year, month: blogpost.pub_month, slug: blogpost.slug}}" class="post-row" v-for="blogpost in group" :key="blogpost.id">
                        <span class="post-row-title">{{ blogpost.title }}</span>
                        <span class="post-row-date">{{ blogpost.published_at | moment("calendar") }}</span>
                    </router-link>
                </template>
            </b-card>
        </b-container>
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