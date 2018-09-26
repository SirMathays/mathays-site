<template>
    <div class="component mt-5 text-center">
        <h1>404</h1>
        <h4 style="text-transform: lowercase" class="mb-4">{{ 'page not found' }}</h4>
        <a href="/">Go to home page</a>
    </div>
</template>

<script>
export default {
    mounted() {
        this.$root.loading = false
    }
}
</script>

