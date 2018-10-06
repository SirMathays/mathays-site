<template>
    <section class="feed">
        <div class="feed-title" :style="'background: ' + feed.theme_color">
            <h1>{{ feed.title }}</h1>
        </div>

        <div v-if="!hideContent" :style="'color: ' + feed.theme_color" class="feed-row" v-for="(row, index) in feed.rss_feed" :key="index">
            <h2><a :href="row.link" target="_blank">{{ row.title }}</a></h2>
            
            <p v-if="row.description">{{ row.description }}</p>

            <div class="row-info" :style="'border-left-color: ' + feed.theme_color">
                <h5 v-if="row.pubDate">{{ row.pubDate | moment('calendar') }}</h5>
                <h5 v-if="row.category">{{ row.category }}</h5>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    computed: {
        
    },
    props: {
        feed: {},
        hideContent: {
            type: Boolean,
            required: true,
        },
    },
}
</script>
