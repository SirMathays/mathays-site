<template>
    <b-modal no-close-on-backdrop :title="feed !== undefined ? 'Edit feed' : 'New feed'" :visible="visible" @show="setup" @hide="$emit('hide')">
        <b-form-group>
            <label>Title</label>
            <b-input placeholder="Title" v-model="form.title"></b-input>
        </b-form-group>
        <b-form-group>
            <label>Url</label>
            <b-input placeholder="Url" v-model="form.url"></b-input>
        </b-form-group>
        <b-form-group>
            <label>Theme color</label>
            <b-input placeholder="Theme color" v-model="form.theme_color"></b-input>
        </b-form-group>
        <b-form-group>
            <label>Limit</label>
            <b-input placeholder="Limit" type="number" v-model="form.limit"></b-input>
        </b-form-group>

        <div slot="modal-footer">
            <b-btn variant="secondary" @click="$emit('hide')">Cancel</b-btn>
            <b-btn variant="primary" @click="saveFeedData">Save</b-btn>
       </div>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            form: {
                title: null,
                url: null,
                theme_color: null,
                limit: null,
            }
        }
    },
    methods: {
        setup() {
            this.$set(this, 'form', { 
                title: this.feed ? this.feed.title : null, 
                url: this.feed ? this.feed.url : null, 
                theme_color: this.feed ? this.feed.theme_color : null, 
                limit: this.feed ? this.feed.limit : null 
            })
        },
        saveFeedData() {
            var app = this
            app.loading = true

            axios.post('/v1/api/admin/personal/save-feed-data', {
                slug: app.$route.params.slug,
                data: {...app.form, id: app.feed ? app.feed.id : null}
            }).then(resp => {
                app.$emit('save')
                app.loading = false
            }).catch(err => {
                app.$root.store.setMessageAction(err.response.data.message || "Saving feed was unsuccessful", 'danger')
            })
        }
    },
    props: {
        feed: {
            type: [Object, undefined],
            required: false
        },
        visible: {
            type: Boolean,
            default: true
        }
    }
}
</script>