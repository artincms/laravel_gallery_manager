<template>
    <div class="main_gallery_div" :style="{margin:margin_el+ 'px'}">
        <div class="stack text-center">
            <generate-loader v-if="showLoader"></generate-loader>
            <div @click="changeGallery(item.encode_id)" class="showImage height_225 thumb_zoom">
                <img class="img_galleyr pointer" :src="'/LFM/DownloadFile/ID/'+item.encode_file_id+'/small/404.png/100/272/208'">
                <i class="lgs-icon fa-lgs-folder-open1 folder_show_folder pointer"></i>
            </div>
            <div class="showContent">
                <div class="showOperateion">
                    <operation :item="item" type="gallery" :model="'ArtinCMS\\LGS\\Model\\Gallery'"></operation>
                </div>
                <div class="showTitle">
                    <a class="pointer" @click="changeGallery(item.encode_id)"><h5 class="title_item_h">{{item.title}}</h5></a>
                </div>
            </div>
            <div class="showTags"><i class="fas fa-tags"></i><span>{{ t('tags') }}</span></div>
        </div>
    </div>
</template>

<script>
    import operation from './operation'
    import generateLoader from './generate_loader'
    export default {
        name: "gallery-style",
        props:['item','margin_el'],
        components:{
            operation,generateLoader
        },
        data: function () {
            return {
            }
        },
        computed: {
            showLoader:function () {
                if(this.item.encode_id == this.$parent.click_id)
                {
                    return true ;
                }
                else
                    return false ;
            }
        },
        methods:{
            changeGallery :function (gallery_id) {
                this.$parent.getGallery(gallery_id);
            }
        }
    }
</script>

<style scoped>

</style>