<template>
    <div ref="infowindow" class="pop-up" :id="pinName">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: [
            'latitude',
            'longitude',
            'title'
        ],

        data() {
            return {
                pinName: '',
                markerCoordinates: {}
            }
        },

        mounted(){
            this.pinName = this.title.toLowerCase().replace(/ /g, '');
            this.markerCoordinates = {
                latitude: this.latitude,
                longitude: this.longitude
            }
        }

    }
 </script>