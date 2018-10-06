<template>
    <b-container v-if="!$root.loading">
        <b-form-group v-for="setting in settings" :key="setting.key">
            <label v-html="setting.key"></label>
            <template v-if="setting.type == 'text'">
                <b-input v-model="setting.value"></b-input>
            </template>
            <template v-else-if="setting.type == 'textarea'">
                <b-textarea rows="4" v-model="setting.value"></b-textarea>
            </template>
        </b-form-group>
        <b-form-group>
            <b-btn size="lg" variant="success" :disabled="saving" @click="save">Save</b-btn>
        </b-form-group>
    </b-container>
</template>

<script>
export default {
    data() {
        return {
            saving: false,
            settings: [],
        }
    },
    methods: {
        getSettings() {
            var app = this

            axios.get('/v1/api/admin/setting-index')
            .then(function (resp) {
                app.settings = resp.data.settings
                app.$root.loading = false
            }).catch(function (resp) {
                app.$root.store.setMessageAction("Could not load rows", 'danger')
                app.$root.loading = false
            })
        },
        save() {
            var app = this
            app.saving = true

            axios.post('/v1/api/admin/store-settings', {settings: app.settings})
            .then(function (resp) {
                app.saving = false
                app.$root.store.setMessageAction(resp.data.message, 'success')
                location.reload()
            }).catch(function (err) {
                app.saving = false
                var errs = err.response.data.errors
                app.$root.store.setMessageAction(errs[Object.keys(errs)[0]][0], 'danger')
            })
        }
    },
    mounted() {
        this.getSettings()
    }
}
</script>

