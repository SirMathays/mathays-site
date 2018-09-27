<template>
    <b-container v-if="!$root.loading">
        <div class="post-edit-wrapper">
            <b-form-group>
                <div class="edit-title">
                    <b-input size="lg" placeholder="Title" v-model="post.title" />
                </div>
                
                <div class="btn-container">
                    <b-btn size="sm" variant="outline-secondary" @click="post.lang = 'fi'" :class="{active: post.lang == 'fi'}">Written in Finnish</b-btn>
                    <b-btn size="sm" variant="outline-secondary" @click="post.lang = 'en'" :class="{active: post.lang == 'en'}">Written in English</b-btn>
                </div>

                <vue-editor :editorOptions="editorOptions" :editorToolbar="customToolbar" placeholder="Become the storyteller..." v-model="post.body"></vue-editor>
            </b-form-group>
        </div>

        <b-form-group>
            <b-btn v-if="!post.published_at" size="lg" variant="success" :disabled="saving" @click="save(true)">Publish</b-btn>
            <b-btn size="lg" variant="outline-secondary" :disabled="saving" @click="save(false)">{{ !post.published_at ? 'Save as Draft' : 'Save' }}</b-btn>
            <b-btn v-if="post.published_at" class="ml-auto" size="lg" variant="danger" :disabled="saving" @click="deletePost">Delete</b-btn>
        </b-form-group>
    </b-container>
</template>

<script>
import { VueEditor, Quill } from "vue2-editor"
import _ from 'lodash'

export default {
    data() {
        return {
            saving: false,
            post: {
                id: undefined,
                title: undefined,
                body: undefined,
                lang: 'fi',
                published_at: undefined,
            },
            errors: [],
            editorOptions: { theme: 'bubble' },
            customToolbar: [
                [{'header': [1, 2, 3, 4, 5, 6, false]}],
                ['bold', 'italic', 'underline'],
                [{'align': ''}, {'align': 'center'}, {'align': 'right'}],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['code-block', 'link', 'blockquote'],
            ]
        }
    },
    methods: {
        getPost() {
            var app = this

            axios.post('/v1/api/admin/get-post', {
                id: this.$route.params.id,
            }).then(function (resp) {
                app.post = resp.data.post
                app.$root.loading = false
            }).catch(function (resp) {
                app.$router.push({name: 'not-found'})
            })
        },
        save(publish) {
            var app = this
            app.saving = true

            axios.post('/v1/api/admin/save-post', {post: app.post, publish})
            .then(function (resp) {
                app.saving = false
                app.post = resp.data.post
                app.$root.store.setMessageAction(resp.data.message, 'success')
                app.$router.replace({name: 'post-edit', params: {id: resp.data.post.id}})
            }).catch(function (err) {
                app.saving = false
                var errs = err.response.data.errors
                app.$root.store.setMessageAction(errs[Object.keys(errs)[0]][0], 'danger')
            })
        },
        deletePost() {
            var app = this
            app.saving = true

            axios.post('/v1/api/admin/delete-post', {
                id: this.$route.params.id,
            }).then(function (resp) {
                app.saving = false
                app.$root.store.setMessageAction(resp.data.message, 'success')
                app.$router.push({name: 'blog'})
            }).catch(function (resp) {
                app.saving = false
                var errs = err.response.data.errors
                app.$root.store.setMessageAction(errs[Object.keys(errs)[0]][0], 'danger')
            })
        }
    },
    mounted() {
        if(this.$route.params.id) this.getPost()
        else this.$root.loading = false
    },
    components: {
        VueEditor
    },
}
</script>