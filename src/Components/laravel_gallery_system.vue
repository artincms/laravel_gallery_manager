<template>
<div class="lgs_container_fluid" :class="dClass">
    <div v-if="show_item_temp" class="show_item_temp">
        <breadcrumb v-if="showBread" :item="mygallery" :gallery_id="gallery_id"></breadcrumb>
        <show-item :item="item" :direction="dClass"></show-item>
    </div>
    <div v-else class="show_gallery_temp">
        <div v-if="show_header" class="lgs_gallery_header" :style="{ color: h_f_color, background: h_b_color}">
            <div style="position: relative">
                <div class="header_gallery_image thumb_zoom">
                    <img class="img_header" :src="'/LFM/DownloadFile/ID/'+mygallery.encode_file_id+'/small/404.png/100/410/248'">
                    <div class="header_gallery_opeartioin">
                        <operation ref="mainGallery" :item="mygallery" type="gallery" model="gallery_model" pack="lgs"></operation>
                    </div>
                </div>
                <div class="gallery_content">
                    <h1 class="header_gallery_title">{{mygallery.title}}</h1>
                    <div class="header_galler_description" v-html="mygallery.description"></div>
                    <div class="clearfix">
                    </div>
                </div>
            </div>
        </div>
        <div>
            <breadcrumb v-if="mygallery && showBread" :item="mygallery" :gallery_id="gallery_id"></breadcrumb>
        </div>
        <div class="gallery_items" id="bodyGallery" style="width: 100%;display: flex;flex-wrap: wrap;">
            <back v-if="showback" :item="mygallery" :margin_el="margin_el"></back>
            <gallery-style v-for="(gallery,index) in galleries" :key="gallery.encode_id" :item="gallery" :margin_el="margin_el"></gallery-style>
            <image-style v-for="(image,index) in images" :key="image.encode_id" :item="image" :margin_el="margin_el" ></image-style>
        </div>
    </div>

</div>
</template>

<script>
    import galleryStyle from './gallery/gallery'
    import back from './gallery/back'
    import imageStyle from './gallery/image'
    import operation from './gallery/operation'
    import generateLoader from './gallery/generate_loader'
    import breadcrumb from './gallery/breadcrumb'
    import showItem from './gallery/show-item'
    import VueTranslate from 'vue-translate-plugin'
    Vue.use(VueTranslate);
    window.axios = require('axios');
    export default {
        name: 'laravel_gallery_system',
        props:{
            gallery_id: {
                type: Number,
                default() {
                    return 0;
                },
            },
            lang_id: {
                type: Number,
                default() {
                    return 0;
                },
            },
            rtl: {
                type: Boolean,
                default() {
                    return true;
                },
            },
        },
        data: function () {
            return {
                galleries:[],
                images:[],
                mygallery:false,
                show_header:false,
                showback:false,
                show_loader:false,
                show_item_temp:false,
                click_id:false,
                item:[],
                showBread:false,
                crumb:[],
                h_b_color:'#000000',
                h_f_color:'#ffffff'
            }
        },
        mounted() {
            this.getGallery(this.gallery_id);
            this.increaseVisit();


        },
        computed: {
            margin_el:function () {
                var mbody = document.getElementById('bodyGallery');
                var body_width=mbody.offsetWidth;
                var num_el = Math.floor(body_width/290) ;
                var sum_margin=body_width-(num_el*290);
                var margin_el = Math.floor(sum_margin/(num_el*2));
                //console.log()
                return margin_el-Math.floor((2*body_width)/1140)-1;
            },
            dClass:function () {
                if (this.rtl)
                {
                    return 'rtl'
                }
                else
                {
                    return 'ltr'
                }
            }
        },
        methods: {
            getGallery : function (gallery_id,p_id,g_id) {
                this.click_id = gallery_id ;
                this.show_item_temp=false ;
                this.show_loader = true;
                if(!this.lang_id)
                {
                    this.lang_id = 0 ;
                }
                if(!this.rtl)
                {
                    this.rtl = 'false'
                }
                axios.post("/LGS/getGalleryItemFront", {gallery_id: gallery_id,lang_id:this.lang_id}).then(response => {
                    this.$nextTick(() =>{
                        if(gallery_id !=0)
                        {
                            this.showback=true;
                        }
                        this.show_loader = false;
                        this.galleries = response.data.galleries;
                        this.mygallery = response.data.gallery;
                        this.images = response.data.images;
                        this.show_header = response.data.showHeader;
                        this.showBread = response.data.showBread;
                        this.h_f_color = response.data.h_f_color;
                        this.h_b_color = response.data.h_b_color;
                        if (response.data.lang =='fa')
                        {
                            this.$translate.setLang("fa");
                        }
                        else
                        {
                            this.$translate.setLang("en");
                        }
                        if(parseInt(this.gallery_id) == parseInt(this.mygallery.main_id))
                        {
                            this.showback=false ;
                        }

                    })
                })
            },
            increaseVisit:function () {
               //console.log(this.$refs);
            }
        },
        components: {
            galleryStyle,imageStyle,operation,back,generateLoader,showItem,breadcrumb
        },
        locales: {
            en: {
                'title' : 'Title :',
                'description' : 'Description :',
                'tags' : ': tags',
                'return' : ': Return to'
            },
            fa: {
                'title' : 'عنوان :',
                'description' : ' توضیحات :',
                'tags' : 'برچسب ها :',
                'return' : 'بازگشت به'
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import  './assets/css/customFrontend.css';
    @import  './lib/icon/style.css';
</style>
