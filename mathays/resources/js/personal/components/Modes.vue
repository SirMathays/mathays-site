<template>
    <div class="header-panel">
        <transition name="blur-left" mode="out-in">
            <div class="modes" :key="1" v-if="!change">
                <a href="#" class="link" @click.prevent="change = !change" v-html="mode || '...'"></a>
            </div>
            <div class="modes" :key="2" v-else>
                <router-link 
                    class="link"
                    v-for="(mode, name) in modes" 
                    :key="mode.slug" 
                    :to="{ name: 'home', params: {slug: !mode.default ? mode.slug : undefined}}"
                >{{ name }}</router-link>
                <a href="#" style="margin-left: 4px" class="link" @click.prevent="change = !change"><b>x</b></a>
            </div>
        </transition>

        <div class="justify-content-end">
            <a :href="'/admin/personal/' + mode" class="link">edit</a>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            change: false
        }
    },
    watch: {
        mode: function(newValue, oldValue) {
            if(newValue != oldValue) this.change = false
        }
    },
    props: {
        mode: {},
        modes: {}
    }
}
</script>
