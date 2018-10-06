<template>
    <div class="toaster">
        <transition-group name="toaster-list">
            <b-alert
                v-for="item in store.state.messages"
                :key="item.key"
                :variant="item.type ? item.type : 'info'"
                dismissible
                @dismissed="store.dropMessageItem(item.key)"
                :show="10">
                {{ item.text && item.text }}
            </b-alert>
        </transition-group>
    </div>
</template>

<script>
export default {
    props: {
        store: {
            type: Object,
            required: true
        }
    }
}
</script>
