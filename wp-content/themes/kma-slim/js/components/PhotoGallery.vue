<template>
    <div>
        <div class="photo-gallery">
            <div class="columns is-multiline" >
                <div class="column is-6 is-4-desktop is-3-widescreen" v-for="(photo, index) in photos" v-bind:key="photo.id" >
                    <div class="photo-tile has-text-centered" @click="openViewer(index)">
                        <figure class="image is-3by2 hide-overflow">
                            <img :id="'photo-' + photo.id" :src="photo.url" :alt="photo.name" >
                        </figure>
                        <p>{{ photo.name }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal is-active" style="z-index:999; height:100vh; background-color: rgba(0,0,0,.9)" v-if="galleryIsOpen" >
            <div class="is-flex-col is-justified is-aligned" style="padding:1rem;">
                <div class="is-flex-row is-justified is-aligned" style="height: 85vh; overflow:hidden; padding:1rem;" @click="closeViewer()" >
                    <img :src="activePhoto.url" :alt="activePhoto.name" style="max-width:100%;max-height:100%;" />
                </div>
                <div class="is-flex-row is-justified is-aligned" style="height: 10vh;" >
                    <a style="margin: 0 1rem;" @click="prevPhoto(activePhoto.index)">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 306 306" style="transform: rotate(180deg); height:30px; enable-background:new 0 0 306 306;"  xml:space="preserve">
                            <polygon fill="#FFF" points="94.35,0 58.65,35.7 175.95,153 58.65,270.3 94.35,306 247.35,153"></polygon>
                        </svg>
                    </a>
                    <a style="margin: 0 1rem;" @click="nextPhoto(activePhoto.index)">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 306 306" style="height:30px; enable-background:new 0 0 306 306;"  xml:space="preserve">
                            <polygon fill="#FFF" points="94.35,0 58.65,35.7 175.95,153 58.65,270.3 94.35,306 247.35,153"></polygon>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            dataPhotos: {
                type: Array,
                default: () => []
            }
        },
        data () {
            return {
                photos: [],
                prev: null,
                next: null,
                galleryIsOpen: false,
                activePhoto: {},
                numPhotos: 0
            }
        },
        mounted () {
            this.photos = this.dataPhotos;
            this.numPhotos = this.photos.length;
        },
        methods: {
            openViewer(index){
                this.galleryIsOpen = true;
                this.activePhoto = this.photos[index];
                this.activePhoto.index = index;

                this.$root.modalOpen = true;

                //console.log(this.activePhoto);
            },
            closeViewer(){
                this.galleryIsOpen = false;
                this.$root.modalOpen = false;
            },
            nextPhoto(index){
                let newNum = (index !== this.numPhotos-1 ? index+1 : 0);
                this.activePhoto = this.photos[newNum];
                this.activePhoto.index = newNum;
            },
            prevPhoto(index){
                let newNum = (index !== 0 ? index-1 : this.numPhotos-1);
                this.activePhoto = this.photos[newNum];
                this.activePhoto.index = newNum;
            }
        }
    }
</script>

<style scoped>
    .photo-gallery {
        padding: 2rem 0;
    }
    .photo-tile {
        margin-bottom: 1rem;
    }
</style>