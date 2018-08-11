<template>
<div class="container-fluid" style="direction: rtl">
    <div v-if="show_header" class="lgs_gallery_header color_white">
        <div>
            <div class="header_gallery_image">
                <img class="img_header" :src="'/LFM/DownloadFile/ID/'+mygallery.encode_file_id+'/small/404.png/00/410/225'">
                <div class="header_gallery_opeartioin">
                    <!--<operation :item="mygallery" type="gallery"  :like="mygallery.like" :dis_like="mygallery.dis_like"></operation>-->
                </div>
            </div>
            <div class="gallery_content">
                <h1 class="header_gallery_title">{{mygallery.title}}</h1>
                <p class="header_galler_description">{{mygallery.string_description}}</p>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <div class="gallery_items" style="width: 100%;">
        <generate-loader v-if="show_loader"></generate-loader>
        <back v-if="showback" :parent_id="mygallery.parent_id" :gallery_id="gallery_id" :margin_el="margin_el"></back>
        <gallery-style v-for="(gallery,index) in galleries" :key="gallery.id" :item="gallery" :margin_el="margin_el"></gallery-style>
        <image-style v-for="(image,index) in images" :key="image.title" :item="image" :margin_el="margin_el" ></image-style>
    </div>
</div>
</template>

<script>
    import galleryStyle from './gallery'
    import back from './back'
    import imageStyle from './image'
    import axios from '../../../../../../public/vendor/laravel_gallery_system/packages/axios/index.js'
    import operation from './operation'
    import generateLoader from './generate_loader'
    import custom from '../../../../../../public/vendor/laravel_gallery_system/js/custome_front.js';
    export default {
        name: 'laravel_gallery_system',
        props:['gallery_id'],
        data: function () {
            return {
                galleries:[],
                images:[],
                mygallery:[],
                show_header:false,
                showback:false,
                show_loader:false,
            }
        },
        mounted() {
            this.getGallery(this.gallery_id);

        },
        computed: {
            margin_el:function () {
                var body_width=window.$('.gallery_items').width();
                var num_el = Math.floor(body_width/290) ;
                var sum_margin=body_width-(num_el*290);
                var margin_el = Math.floor(sum_margin/(num_el*2));
                return margin_el-Math.floor((2*body_width)/1330);
            }
        },
        methods: {
            getGallery : function (gallery_id) {
                this.show_loader = true;
                axios.post("/LGS/getGalleryItemFront", {gallery_id: gallery_id}).then(response => {
                    this.$nextTick(() =>{
                        this.show_loader = false;
                        this.galleries = response.data.galleries;
                        this.mygallery = response.data.gallery;
                        this.images = response.data.images;
                        this.show_header = response.data.showHeader;
                    })
                })
            },
            setElement :function (event) {

                // window.$.each(el, function(index,item) {
                //     window.$(item).css({margin:30});
                // });
            }


        },
        components: {
            galleryStyle,imageStyle,operation,back,generateLoader
        }
    }
</script>

<style lang="scss" scoped>
    @import  '../../../../../../public/vendor/laravel_gallery_system/css/customFrontend.css';
    @import  '../../../../../../public/vendor/laravel_gallery_system/packages/fontawesome/fontawesome_v_5_2/css/all.css';

</style>
