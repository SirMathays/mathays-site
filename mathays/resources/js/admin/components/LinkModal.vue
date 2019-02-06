<template>
    <b-modal no-close-on-backdrop :name="link !== undefined ? 'Edit link' : 'New link'" :visible="visible" @show="setup" @hide="$emit('hide')">
        <b-form-group>
            <label>Name</label>
            <b-input placeholder="Name" v-model="form.name"></b-input>
        </b-form-group>
        <b-form-group>
            <label>Url</label>
            <b-input placeholder="Url" v-model="form.url"></b-input>
        </b-form-group>
        <b-form-group>
            <label>Color</label>
            <b-input placeholder="Color" v-model="form.color"></b-input>
        </b-form-group>

        <div slot="modal-footer">
            <b-btn variant="secondary" @click="$emit('hide')">Cancel</b-btn>
            <b-btn variant="primary" @click="saveLinkData">Save</b-btn>
       </div>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            form: {
                name: null,
                url: null,
                color: null
            }
        }
    },
    methods: {
        setup() {
            this.$set(this, 'form', { 
                name: this.link ? this.link.name : null, 
                url: this.link ? this.link.url : null, 
                color: this.link ? this.link.color : null
            })
        },
        saveLinkData() {
            var app = this
            app.loading = true

            axios.post('/v1/api/admin/personal/save-link-data', {
                slug: app.$route.params.slug,
                data: {...app.form, id: app.link ? app.link.id : null}
            }).then(resp => {
                app.$emit('save')
                app.loading = false
            }).catch(err => {
                app.$root.store.setMessageAction(err.response.data.message || "Saving link was unsuccessful", 'danger')
            })
        }
    },
    props: {
        link: {
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