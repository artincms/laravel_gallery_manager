<template>
    <div class="main_gallery_div" :style="{margin:margin_el+ 'px'}">
        <div class="stack text-center">
            <div @click="changeGallery(item.id)" class="showImage height_225">
                <img class="img_galleyr pointer" :src="'/LFM/DownloadFile/ID/'+item.encode_file_id+'/small/404.png/100/272/208'">
                <i class="far fa-2x fa-folder-open folder_show_folder pointer"></i>
            </div>
            <div class="showContent">
                <div class="showOperateion">
                    <operation :item="item" type="gallery" :model="'ArtinCMS\\LGS\\Model\\Gallery'"></operation>
                </div>
                <div class="showTitle">
                    <a class="pointer" @click="changeGallery(item.id)"><h5 class="title_item_h">{{item.title}}</h5></a>
                </div>
            </div>
            <div class="showTags"><i class="fas fa-tags"></i><span>برچسب ها:</span></div>
        </div>
    </div>
</template>

<script>
    import operation from './operation'
    export default {
        name: "gallery-style",
        props:['item','margin_el'],
        components:{
            operation
        },
        data: function () {
            return {

            }
        },
        methods:{
            changeGallery :function (gallery_id) {
                this.$parent.getGallery(gallery_id);
                this.$parent.showback=true ;
            }
        }
    }
</script>

<style scoped>

</style>