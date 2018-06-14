<template>
    <div
            class="slide"
            :class="{
                'active': isActive
            }"
            :style="{
                'background-image': 'url(' + image + ')',
                'z-index': zindex,
            }">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            image: ''
        },

        data () {
            return {
                id: '',
                isActive: false
            }
        },

        computed: {
            zindex: function () {
                let index = this.id
                return (20 - index)
            }
        }

    }
</script>
<style>
    .slide {
        width:100%;
        -webkit-transition: all linear 1.5s;
        transition: all linear 1.5s;
        position: absolute;
        z-index: -1;
        opacity: 0;
        background-position: center;
        background-size: conver;
    }
    .slide.active {
        opacity: 1;
        z-index: 0;
    }
    .slide-container {
        align-items: center;
    }

</style>