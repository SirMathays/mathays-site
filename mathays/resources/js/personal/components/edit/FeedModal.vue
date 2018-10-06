<template>
    <b-modal :title="feed.id ? 'Edit feed' : 'New feed'" :visible="visible" @hide="$emit('hide')" @ok="$emit('save')">
        <b-form-group>
            <label>Title</label>
            <b-input placeholder="title" v-model="feed.title"></b-input>
        </b-form-group>
        <b-form-group>
            <label>Url</label>
            <b-input placeholder="url" v-model="feed.url"></b-input>
        </b-form-group>
        <b-form-group>
            <label>Theme color</label>
            <b-input placeholder="theme color" v-model="feed.theme_color"></b-input>
        </b-form-group>
        <b-form-group>
            <label>Limit</label>
            <b-input placeholder="limit" type="number" v-model="feed.limit"></b-input>
        </b-form-group>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            form: {}
        }
    },
    mounted() {
        this.form = this.feed
    },
    props: {
        feed: {
            type: Object,
            required: true
        },
        visible: {
            type: Boolean,
            default: false
        }
    }
}
</script>

