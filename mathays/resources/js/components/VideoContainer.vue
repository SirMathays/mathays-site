<template>
    <div :class="['splash', 'bg-'+bg]" :style="background">
        <b-container>
            <slot></slot>
        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            // 
        }
    },
    computed: {
        background() {
            var values = []
 
            if(!this.noStripe) values.push("repeating-linear-gradient(-45deg, black 0px, black 2px, rgba(0,0,0,0.5) 2px, rgba(0,0,0,0.5) 4px)")
            
            if(this.url) values.push("url('" + this.url + "')")

            if(values.length > 0) return "background:" + values.join()

            return undefined
        }
    },
    props: {
        url: {
            type: String,
            required: false
        },
        noStripe: {
            type: Boolean,
            default: false
        },
        bg: {
            type: String,
            default: 'dark'
        }
    },
}
</script>

