<template>
<div class="container-fluid" style="direction: rtl">
    <div v-if="show_header" class="lgs_gallery_header color_white">
        <div class="row">
            <div class="header_gallery_image">
                <img class="img_header" :src="'/LFM/DownloadFile/ID/'+mygallery.encode_img_id+'/small/404.png/00/410/225'">
                <div class="header_gallery_opeartioin">
                    <operation :item="mygallery" type="gallery"  :like="mygallery.like" :dis_like="mygallery.dis_like"></operation>
                </div>
            </div>
            <div class="gallery_content col-lg-8">
                <h1 class="header_gallery_title">{{mygallery.title}}</h1>
                <p class="header_galler_description">{{mygallery.string_description}}</p>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <div class="gallery_items">
        <back v-if="showback" :parent_id="mygallery.parent_id" :gallery_id="gallery_id"></back>
        <gallery-style v-for="(gallery,index) in galleries" :key="gallery.id" :item="gallery"></gallery-style>
        <image-style v-for="(image,index) in images" :key="image.title" :item="image" ></image-style>
    </div>
</div>
</template>

<script>
    import galleryStyle from './gallery'
    import back from './back'
    import imageStyle from './image'
    import axios from 'axios'
    import operation from './operation'
    export default {
        name: 'laravel_gallery_system',
        props:['gallery_id'],
        data: function () {
            return {
                galleries:[],
                images:[],
                mygallery:[],
                show_header:true,
                showback:false
            }
        },
        mounted() {
            this.getGallery(this.gallery_id)
        },
        methods: {
            getGallery : function (gallery_id) {
                if(gallery_id == 0)
                {
                    this.show_header=false;
                }
                axios.post("/LGS/getGalleryItemFront", {gallery_id: gallery_id}).then(response => {
                    this.$nextTick(() =>{
                        this.galleries = response.data.galleries;
                        this.mygallery = response.data.gallery;
                        this.images = response.data.images;
                    })
                })
            }
        },
        components: {
            galleryStyle,imageStyle,operation,back
        }

    }
</script>

<style lang="scss" scoped>
    @import  '../../../../../../public/vendor/laravel_gallery_system/css/customFrontend.css';
    @import  '../../../../../../public/vendor/laravel_gallery_system/packages/fontawesome/fontawesome_v_5_2/css/all.css';

</style>
