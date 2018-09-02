<template>
<div class="lgs_container_fluid" :class="dClass">
    <div v-if="show_item_temp" class="show_item_temp">
        <breadcrumb :item="mygallery" :gallery_id="gallery_id"></breadcrumb>
        <show-item :item="item" :direction="dClass"></show-item>
    </div>
    <div v-else class="show_gallery_temp">
        <div v-if="show_header" class="lgs_gallery_header color_white">
            <div>
                <div class="header_gallery_image thumb_zoom">
                    <img class="img_header" :src="'/LFM/DownloadFile/ID/'+mygallery.encode_file_id+'/small/404.png/100/410/225'">
                    <div class="header_gallery_opeartioin">
                        <operation ref="mainGallery" :item="mygallery" type="gallery" :model="'ArtinCMS\\LGS\\Model\\Gallery'"></operation>
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
        <div>
            <breadcrumb v-if="mygallery" :item="mygallery" :gallery_id="gallery_id"></breadcrumb>
        </div>
        <div class="gallery_items" id="bodyGallery" style="width: 100%;">
            <generate-loader v-if="show_loader"></generate-loader>
            <back v-if="showback" :parent_id="mygallery.encode_parent_id" :gallery_id="gallery_id" :margin_el="margin_el"></back>
            <gallery-style v-for="(gallery,index) in galleries" :key="gallery.id" :item="gallery" :margin_el="margin_el"></gallery-style>
            <image-style v-for="(image,index) in images" :key="image.title" :item="image" :margin_el="margin_el" ></image-style>
        </div>
    </div>

</div>
</template>

<script>
    import galleryStyle from './gallery'
    import back from './back'
    import imageStyle from './image'
    import axios from '../lib/axios/index.js'
    import operation from './operation'
    import generateLoader from './generate_loader'
    import breadcrumb from './breadcrumb'
    import showItem from './show-item'
    import VueTranslate from '../lib/vue-translate-plugin/dist/vue-translate.js'
    import VueScrollTo from '../lib/vue-scrollto';
    import FullScreenView from  '../lib/FullScreenView.js';
    Vue.use(VueTranslate);
    Vue.use(VueScrollTo, {
        container: "body",
        duration: 1000,
        easing: "ease-in-out",
        offset: -60,
        cancelable: true,
        onStart: false,
        onDone: false,
        onCancel: false,
        x: false,
        y: true
    })
    export default {
        name: 'laravel_gallery_system',
        props:['gallery_id','rtl','lang_id'],
        data: function () {
            return {
                galleries:[],
                images:[],
                mygallery:false,
                show_header:false,
                showback:false,
                show_loader:false,
                show_item_temp:false,
                item:[],
                crumb:[]
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
                if (this.rtl == 'true')
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
            getGallery : function (gallery_id) {
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
                        this.show_loader = false;
                        this.galleries = response.data.galleries;
                        this.mygallery = response.data.gallery;
                        this.images = response.data.images;
                        this.show_header = response.data.showHeader;
                        if (response.data.lang =='fa')
                        {
                            this.$translate.setLang("fa");
                        }
                        else
                        {
                            this.$translate.setLang("en");
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
                'tags' : ': tags'
            },
            fa: {
                'title' : 'عنوان :',
                'description' : ': توضیحات :',
                'tags' : 'برچسب ها :'
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import  '../assets/css/customFrontend.css';
    @import  '../lib/icon/style.css';
</style>
