<template>
    <b-container v-if="!$root.loading">
        <b-card class="my-4">
            <h4>Drafts</h4>
            <router-link class="post-row" v-for="draft in drafts" :key="draft.id" :to="{name: 'post-edit', params: {id: draft.id}}">
                <span class="post-row-title">{{ draft.title }}</span>
                <span class="post-row-date">Last edited: {{ draft.updated_at | moment('calendar') }}</span>
            </router-link>
            <p v-if="drafts.length <= 0">No drafts</p>
        </b-card>

        <b-btn :to="{ name: 'post-edit' }" size="lg" variant="dark" block class="my-4">Write a blog post</b-btn>

        <b-card>
            <h4>Published</h4>
            <router-link class="post-row" v-for="post in published" :key="post.id" :to="{name: 'post-edit', params: {id: post.id}}">
                <span class="post-row-title">{{ post.title }}</span>
                <span class="post-row-date">{{ post.published_at_tz | moment('calendar') }}</span>
            </router-link>
            <p v-if="published.length <= 0">No published posts. Go and publish some!</p>
        </b-card>
    </b-container>
</template>

<script>
export default {
    data() {
        return {
            posts: [],
        }
    },
    computed: {
        drafts() {
            return this.posts.filter((post, key) => {
                return post.published_at_tz == null
            })
        },
        published() {
            return this.posts.filter((post, key) => {
                return post.published_at_tz != null
            })
        }
    },
    methods: {
        getPosts() {
            var app = this

            axios.get('/v1/api/admin/post-index')
            .then(function (resp) {
                app.posts = resp.data.posts
                app.$root.loading = false
            }).catch(function (resp) {
                app.$root.store.setMessageAction("Could not load rows", 'danger')
                app.$root.loading = false
            })
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>