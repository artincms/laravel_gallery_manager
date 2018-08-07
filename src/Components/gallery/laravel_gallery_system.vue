<template>
<div class="container">
    <div class="header"></div>
    <gallery-style v-for="(gallery,index) in galleries" :key="gallery.id" :item="gallery"></gallery-style>
    <image-style v-for="(image,index) in images" :key="image.title" :item="image" ></image-style>
</div>
</template>

<script>
    import galleryStyle from './gallery'
    import imageStyle from './image'
    import axios from 'axios'
    export default {
        name: 'laravel_gallery_system',
        props:['gallery_id'],
        data: function () {
            return {
                galleries:[],
                images:[],
            }
        },
        mounted() {
            this.getGallery()
        },
        methods: {
            getGallery : function () {
                axios.post("/LGS/getGalleryItemFront", {gallery_id: this.gallery_id}).then(response => {
                    this.$nextTick(() =>{
                        this.galleries = response.data.galleries;
                        this.images = response.data.images;
                    })
                })
            }
        },
        components: {
            galleryStyle,imageStyle
        }

    }
</script>

<style lang="scss" scoped>
    @import  '../../../../../../public/vendor/laravel_gallery_system/css/customFrontend.css';
    @import  '../../../../../../public/vendor/laravel_gallery_system/packages/fontawesome/fontawesome_v_5_2/css/all.css';

</style>
