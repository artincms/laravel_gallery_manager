<template>
    <div class="galllery_image_div">
        <div class="stack text-center">
            <div v-if="item.type==0" class="showImage height_225">
                <img class="img_galleyr showFullScreen" :src="'/LFM/DownloadFile/ID/'+item.encode_file_id+'/small/404.png/100/272/208'" :data-caption="item.description" :data-title="item.title" :id="'fullImage'+ item.encode_id" :data-image="'/LFM/DownloadFile/ID/'+item.encode_file_id+'/small/404.png/100/272/208'">
            </div>
            <div v-if="item.type==2" class="height_225 back_gray">
                <video controls  width="100%" height="205" >
                    <source v-for="file_id in item.encode_file_id" :src="'/LFM/DownloadFile/ID/'+file_id" type="video/mp4">
                </video>
            </div>
            <div class="audio_parent_div height_225" v-if="item.type==1" width="250" height="150">
                <audio class="audio_file" controls width="250" height="150">
                    <source v-for="file_id in item.encode_file_id" :src="'/LFM/DownloadFile/ID/'+file_id" type="video/mp4">
                </audio>
            </div>
            <div class="showContent">
                <div class="showOperateion">
                    <operation :item="item"  :like="item.like" :dis_like="item.dis_like" type="image"></operation>
                </div>
                <div class="showTitle">
                    <a class="pointer" @click="changeImage(item.id)"><h5 class="title_item_h">{{item.title}}</h5></a>
                </div>
            </div>
            <div class="showTags"><i class="fas fa-tags">
            </i><span>برچسب ها:</span>
                <br>
            </div>
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
        },
        methods:{
            changeImage:function () {

            }
        }
    }
</script>

<style scoped>

</style>