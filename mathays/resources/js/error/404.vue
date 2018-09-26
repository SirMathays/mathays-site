<template>
    <div class="component mt-5 text-center">
        <h1>404</h1>
        <h4 style="text-transform: lowercase" class="mb-4">{{ 'page not found' }}</h4>
        <router-link :to="target.route">{{ target.text }}</router-link>
    </div>
</template>

<script>
export default {
    mounted() {
        this.$root.loading = false
    },
    props: {
        target: {
            default: { route: {name: 'home'}, text: 'Go to home page'},
            type: Object
        }
    }
}
</script>

