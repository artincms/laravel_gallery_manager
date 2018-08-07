<template>
    <div class="main_gallery_div">
        <div class="stack text-center">
            <p class="showImage">
                <img :src="'/LFM/DownloadFile/ID/'+item.encode_id+'/small/404.png/00/250/200'">
                <i class="far fa-folder-open folder_show_folder"></i>
            </p>
            <div class="showContent">
                <div class="showOperateion">
                    <operation :item="item"></operation>
                </div>
                <div class="showTitle">
                    <span>{{item.title}}</span>
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
        props:['item'],
        components:{
            operation
        }
    }
</script>

<style scoped>

</style>