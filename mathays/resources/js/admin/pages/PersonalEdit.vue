<template>
    <b-container v-if="!$root.loading">
        <div class="my-4">
            <b-nav tabs>
                <b-nav-item v-for="(mode, slug) in modes" :key="slug" :to="{ name: 'personal', params: {slug: mode.slug}}">{{ mode.name }}</b-nav-item>
                <b-nav-item href="/personal" class="tab-dark ml-auto" :disabled="Object.keys(modes).length <= 0">Personal ></b-nav-item>
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
                                @end="handleOrder('links')"
                            >
                                <b-list-group-item 
                                    tag="a"
                                    href="javascript:void(0)"
                                    class="text-center"
                                    v-for="(link, index) in modeContent.links" 
                                    @click.prevent="activeLink = link.id"
                                    :key="index"
                                    :variant="link.color"
                                >{{ link.name }}</b-list-group-item>
                            </draggable>
                        </b-form-group>

                        <b-form-group>
                            <b-btn @click="activeLink = 'new'">Add link</b-btn>
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
                                @end="handleOrder('feeds')"
                            >
                                <b-list-group-item 
                                    tag="a"
                                    href="javascript:void(0)"
                                    class="text-center"
                                    v-for="(feed, index) in modeContent.feeds" 
                                    @click.prevent="activeFeed = feed.id"
                                    :key="index"
                                >{{ feed.title }}</b-list-group-item>                    
                            </draggable>
                        </b-form-group>

                        <b-form-group>
                            <b-btn @click="activeFeed = 'new'">Add feed</b-btn>
                        </b-form-group>
                    </div>

                    <div v-if="showTrash">
                        <draggable v-model="trash.rows" class="draggable-list trash" data-title="Trash" :options="trash.options"></draggable>
                    </div>
                </b-card>
                <b-card key="loading" v-else-if="modeLoading">
                    Loading mode content.
                </b-card>
                <b-card key="none" v-else-if="Object.keys(modes).length > 0">
                    Select a mode.
                </b-card>
                <b-card key="create-mode" v-else>
                    No modes found. <a href="#">Go and create one!</a>
                </b-card>
            </transition>
        </div>

        <link-modal
            :visible="showModal == 'link'"
            :link="activeLinkData"
            @hide="showModal = undefined"
            @save="handleModalUpdate"
        />

        <feed-modal
            :visible="showModal == 'feed'"
            :feed="activeFeedData"
            @hide="showModal = undefined"
            @save="handleModalUpdate"
        />
    </b-container>
</template>

<script>
import draggable from 'vuedraggable'
import FeedModal from '../components/FeedModal'
import LinkModal from '../components/LinkModal'

export default {
    data() {
        return {
            saving: false,
            modeLoading: false,
            modes: {},
            modeContent: {
                links: [],
                feeds: []
            },
            trash: {
                options: { group: { name: 'trash', put: () => true, pull: false }},
                rows: [],
            },
            showTrash: false,
            activeFeed: undefined,
            activeLink: undefined,
        }
    },
    computed: {
        activeMode() {
            return this.$route.params.slug
        },
        showModal: {
            get() {
                if (this.activeFeed) return 'feed'
                else if (this.activeLink) return 'link'

                return false
            },
            set(value) {
                if (this.activeFeed) this.activeFeed = value
                if (this.activeLink) this.activeLink = value
            }
        },
        activeLinkData() {
            if(!this.activeLink || this.activeLink == 'new') return undefined

            return this.modeContent.links.find(item => {
                return item.id == this.activeLink
            })
        },
        activeFeedData() {
            if(!this.activeFeed || this.activeFeed == 'new') return undefined

            return this.modeContent.feeds.find(item => {
                return item.id == this.activeFeed
            })
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
        handleModalUpdate() {
            this.getModeContent()
            this.showModal = undefined
        },
        deleteRow(target) {
            
        },
        handleOrder(target) {
            var app = this

            app.showTrash = false
            var orderChanged = false

            var rows = []

            app.modeContent[target].map((item, key) => {
                var before = item.order
                var after = key+1

                if(before !== after) {
                    app.modeContent[target][key].order = after
                    rows.push({id: item.id, order: after})
                    orderChanged = true
                }
            })

            if(!orderChanged) return

            axios.post('/v1/api/admin/personal/handle-order', {
                slug: app.$route.params.slug, [target]: rows
            }).then((resp) => {
                // 
            }).catch((err) => {
                app.$root.store.setMessageAction(err.response.data.message || "Saving order was unsuccessful", 'danger')
            })
        },
        getModes() {
            var app = this
            app.$root.loading = true

            axios.get('/v1/api/admin/personal/get-modes')
            .then((resp) => {
                app.modes = resp.data.modes
                app.$root.loading = false
            }).catch((err) => {
                app.$root.store.setMessageAction(err.response.data.message || "Could not load modes", 'danger')
                app.$root.loading = false
            })
        },
        getModeContent() {
            var app = this
            app.modeLoading = true

            axios.post('/v1/api/admin/personal/get-mode-content', {
                slug: app.$route.params.slug
            }).then((resp) => {
                app.modeContent = resp.data
                app.modeLoading = false
            }).catch((err) => {
                app.$root.store.setMessageAction(err.response.data.message || "Could not load modes", 'danger')
                app.modeLoading = false
            })
        }
    },
    mounted() {
        this.getModes()
    },
    components: {
        draggable,
        FeedModal,
        LinkModal
    }
}
</script>

<style lang="scss">

</style>
