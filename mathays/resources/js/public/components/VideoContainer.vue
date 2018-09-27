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
 
            if(!this.noStripe) values.push("repeating-linear-gradient(-45deg, black 0px, black 4px, rgba(0,0,0,0.2) 4px, rgba(0,0,0,0.2) 8px)")

            values.push("linear-gradient(to left, rgba(0,0,0,.6), transparent, rgba(0,0,0,.6))")
            
            if(this.url) values.push("url('" + this.url + "')")

            return "background-image:" + values.join()
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

