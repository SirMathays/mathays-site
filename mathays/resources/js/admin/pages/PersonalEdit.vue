<template>
    <b-container v-if="!$root.loading">
        <div class="my-4">
            <b-nav tabs>
                <b-nav-item v-for="(mode, slug) in modes" :key="slug" :to="{ name: 'personal', params: {slug: mode.slug}}">{{ mode.name }}</b-nav-item>
                <b-nav-item href="/personal" class="tab-dark ml-auto">Personal ></b-nav-item>
            </b-nav>

            <transition name="slide-hor" mode="out-in">
                <b-card :key="activeMode" v-if="activeMode && !modeLoading">
                    <div class="mb-4">
                        <b-form-group>
                            <h4>Quick links</h4>
                            <draggable 
                                element="b-list-group" 
                                class="draggable-list" 
                                data-title="Links" 
                                v-model="modeContent.links" 
                                @start="showTrash = true" 
                                @end="showTrash = false"
                            >
                                <b-list-group-item 
                                    class="text-center"
                                    v-for="(link, index) in modeContent.links" 
                                    :key="index"
                                    :variant="link.color">
                                    <span>{{ link.name }}</span>
                                    <a href="#">Edit</a>
                                </b-list-group-item>
                            </draggable>
                        </b-form-group>

                        <b-form-group>
                            <b-btn>Add link</b-btn>
                        </b-form-group>
                    </div>

                    <div class="mb-4">
                        <b-form-group>
                            <h4>Feeds</h4>
                            <draggable 
                                element="b-list-group" 
                                class="draggable-list" 
                                data-title="Feeds" 
                                v-model="modeContent.feeds" 
                                @start="showTrash = true" 
                                @end="showTrash = false"
                            >
                                <b-list-group-item 
                                    class="text-center"
                                    v-for="(feed, index) in modeContent.feeds" 
                                    :key="index"
                                >{{ feed.title }}</b-list-group-item>                    
                            </draggable>
                        </b-form-group>

                        <b-form-group>
                            <b-btn>Add link</b-btn>
                        </b-form-group>
                    </div>

                    <div v-if="showTrash">
                        <draggable v-model="trash.rows" class="draggable-list trash" data-title="Trash" :options="trash.options"></draggable>
                    </div>
                </b-card>
                <b-card key="loading" v-else-if="modeLoading">
                    Loading mode content.
                </b-card>
                <b-card key="none" v-else>
                    Select a mode.
                </b-card>
            </transition>
        </div>
    </b-container>    
</template>

<script>
import draggable from 'vuedraggable'

export default {
    data() {
        return {
            saving: false,
            modeLoading: false,
            showTrash: false,
            modes: {},
            modeContent: {
                links: [],
                feeds: []
            },
            trash: {
                options: { group: { name: 'trash', put: () => true, pull: false }},
                rows: [],
            },
        }
    },
    computed: {
        activeMode() {
            return this.$route.params.slug
        }
    },
    watch: {
        '$route.params.slug': {
            immediate: true,
            handler: function(newValue, oldValue) {
                if(newValue !== undefined) {
                    this.modeContent = {links: [], feeds: []}
                    this.getModeContent()
                }
            }
        }
    },
    methods: {
        getModes() {
            var app = this
            app.$root.loading = true

            axios.get('/v1/api/admin/personal/get-modes')
            .then(function (resp) {
                app.modes = resp.data.modes
                app.$root.loading = false
            }).catch(function (resp) {
                app.$root.store.setMessageAction("Could not load modes", 'danger')
                app.$root.loading = false
            })
        },
        getModeContent() {
            var app = this
            app.modeLoading = true

            axios.post('/v1/api/admin/personal/get-mode-content', {
                slug: app.$route.params.slug
            }).then(function (resp) {
                app.modeContent = resp.data
                app.modeLoading = false
            }).catch(function (resp) {
                app.$root.store.setMessageAction("Could not load modes", 'danger')
                app.modeLoading = false
            })
        }
    },
    mounted() {
        this.getModes()
    },
    components: {
        draggable
    }
}
</script>

<style lang="scss">

</style>
