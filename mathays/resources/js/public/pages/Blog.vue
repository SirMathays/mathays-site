<template>
    <div class="component" v-if="!$root.loading">
        <b-container v-if="newest">
            <h2 class="mt-4">newest post</h2>

            <router-link :to="{ name: 'post', params: {year: newest.pub_year, month: newest.pub_month, slug: newest.slug}}" class="card video-card mb-5">
                <div class="bottom-fade"></div>
                <div class="card-body video-child">
                    <h4 class="card-title">{{ newest.title }}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">{{ newest.published_at_tz | moment('calendar') }}</h6>
                    <div v-html="newest.body"></div>
                </div>
            </router-link>
        </b-container>
        
        <b-container class="my-4">
            <div class="title-container">
                <h2>previous posts</h2>

                <div class="filter-links">
                    <a href="#" @click.prevent="posts.filter = undefined">
                        <span class="normal">Show all</span>
                        <span class="mobile">all</span>
                    </a>
                    <a href="#" @click.prevent="posts.filter = 'en'">
                        <span class="normal">Written in English</span>
                        <span class="mobile">🇬🇧</span>
                    </a>
                    <a href="#" @click.prevent="posts.filter = 'fi'">
                        <span class="normal">Written in Finnish</span>
                        <span class="mobile">🇫🇮</span>
                    </a>
                </div>
            </div>

            <b-card class="post-list">
                <p v-if="Object.keys(posts.rows).length <= 0">No posts... yet</p>

                <paginate name="posts" tag="div" :list="filteredPosts" :per="posts.per">
                    <template v-for="(group, groupIndex) in groupedPosts">
                        <p class="post-group-title" :key="groupIndex">{{ [groupIndex, 'YYYY-MM'] | moment("MMM YYYY") }}</p>
                        <router-link :to="{name: 'post', params: {year: blogpost.pub_year, month: blogpost.pub_month, slug: blogpost.slug}}" class="post-row" v-for="blogpost in group" :key="blogpost.id">
                            <span class="post-row-title">{{ blogpost.title }}</span>
                            <span class="post-row-date">{{ blogpost.published_at_tz | moment("calendar") }}</span>
                        </router-link>
                    </template>
                </paginate>

                <paginate-links for="posts" :showStepLinks="true" :stepLinks="{ prev: '‹', next: '›' }"></paginate-links>
            </b-card>
        </b-container>
    </div>
</template>

<script>
import _ from 'lodash'

export default {
    data() {
        return {
            paginate: ['posts'],
            newest: undefined,
            posts: {
                filter: undefined,
                rows: [],
                per: 10
            },
        }
    },
    computed: {
        totalRows() {
            return this.posts.rows.length
        },
        filteredPosts() {
            if(!this.posts.filter) return this.posts.rows

            var app = this
            return app.posts.rows.filter((post, key) => {
                return post.lang == app.posts.filter
            })
        },
        groupedPosts() {
            return _.groupBy(this.paginated('posts'), function(post) {
                return post.pub_year_month
            })
        }
    },
    methods: {
        getBlogposts() {
            var app = this

            axios.get('/v1/api/get-blog')
            .then(function (resp) {
                app.posts.rows = resp.data.blogposts
                app.newest = resp.data.newest
                app.$root.loading = false
            }).catch(function (resp) {
                app.$root.store.setMessageAction("Could not load rows", 'danger')
                app.$root.loading = false
            })
        }
    },
    mounted() {
        this.getBlogposts()
    }
}
</script>