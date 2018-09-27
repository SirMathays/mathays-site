<template>
    <b-container v-if="!$root.loading">
        <b-form-group>
            <b-input size="lg" placeholder="Title" v-model="video.title" />
        </b-form-group>

        <b-form-group>
            <youtube v-if="video.yid" :video-id="video.yid" player-width="100%" player-height="auto"></youtube>
            <b-input size="lg" placeholder="Youtube Link" v-model="url" />
        </b-form-group>
    
        <b-form-group>
            <vue-editor :editorOptions="editorOptions" :editorToolbar="customToolbar" placeholder="Description" v-model="video.description"></vue-editor>
        </b-form-group>

        <b-form-group>
            <b-btn v-if="!video.published_at_tz" size="lg" variant="success" :disabled="saving" @click="save(true)">Publish</b-btn>
            <b-btn size="lg" variant="outline-secondary" :disabled="saving" @click="save(false)">{{ !video.published_at_tz ? 'Save as Draft' : 'Save' }}</b-btn>
            <b-btn v-if="video.published_at" class="ml-auto" size="lg" variant="danger" :disabled="saving" @click="deleteVideo">Delete</b-btn>
        </b-form-group>
    </b-container>
</template>

<script>
import { VueEditor, Quill } from "vue2-editor";

export default {
    data() {
        return {
            saving: false,
            url: undefined,
            video: {
                id: undefined,
                yid: undefined,
                title: undefined,
                description: undefined,
                published_at: undefined,
            },
            editorOptions: { theme: 'bubble' },
            customToolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
            ]
        }
    },
    watch: {
        url: function(newValue) {
            if(newValue.indexOf('youtu.be/') >= 0) {
                this.video.yid = newValue.substring(newValue.indexOf("youtu.be/")+9)    
            } else if (newValue.indexOf('watch?v=') >= 0) {
                this.video.yid = newValue.substring(newValue.indexOf("watch?v=")+8)
            } else {
                this.video.yid = newValue
            }
        }
    },
    methods: {
        getVideo() {
            var app = this

            axios.post('/v1/api/admin/get-video', {
                id: this.$route.params.id,
            }).then(function (resp) {
                app.video = resp.data.video
                app.url = resp.data.video.url
                app.$root.loading = false
            }).catch(function (resp) {
                app.$router.push({name: 'not-found'})
            })
        },
        save(publish) {
            var app = this
            app.saving = true

            axios.post('/v1/api/admin/save-video', {video: app.video, publish})
            .then(function (resp) {
                app.saving = false
                app.video = resp.data.video
                app.$root.store.setMessageAction(resp.data.message, 'success')
                app.$router.replace({name: 'video-edit', params: {id: resp.data.video.id}})
            }).catch(function (err) {
                app.saving = false
                var errs = err.response.data.errors
                app.$root.store.setMessageAction(errs[Object.keys(errs)[0]][0], 'danger')
            })
        },
        deleteVideo() {
            var app = this
            app.saving = true

            axios.post('/v1/api/admin/delete-video', {
                id: this.$route.params.id,
            }).then(function (resp) {
                app.saving = false
                app.$root.store.setMessageAction(resp.data.message, 'success')
                app.$router.push({name: 'videos'})
            }).catch(function (resp) {
                app.saving = false
                var errs = err.response.data.errors
                app.$root.store.setMessageAction(errs[Object.keys(errs)[0]][0], 'danger')
            })
        }
    },
    mounted() {
        if(this.$route.params.id) this.getVideo()
        else this.$root.loading = false
    },
    components: {
        VueEditor
    },
}
</script>