<template>
    <div class="galllery_image_div">
        <div class="stack text-center">
            <p v-if="item.type==0" class="showImage">
                <img :src="'/LFM/DownloadFile/ID/'+item.encode_file_id+'/small/404.png/00/250/200'">
            </p>
            <div v-if="item.type==2" width="250" height="150">
                <video controls  width="250" height="150" >
                    <source v-for="file_id in item.encode_file_id" :src="'/LFM/DownloadFile/ID/'+file_id" type="video/mp4">
                </video>
            </div>
            <div class="audio_parent_div" v-if="item.type==1" width="250" height="150">
                <audio class="audio_file" controls width="250" height="150">
                    <source v-for="file_id in item.encode_file_id" :src="'/LFM/DownloadFile/ID/'+file_id" type="video/mp4">
                </audio>
            </div>
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
        name: "image-style",
        props:['item'],
        components:{
            operation
        }
    }
</script>

<style scoped>

</style>