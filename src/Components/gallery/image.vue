<template>
    <div class="galllery_image_div"  :style="{margin:margin_el+ 'px'}">
        <div class="stack_image text-center" style="height: 100%;">
            <generate-loader v-if="showLoader"></generate-loader>
            <div v-if="item.type==0" class="height_225 thumb_zoom" @click="showItem">
                <img class="img_galleyr pointer"  :src="'/LFM/DownloadFile/ID/'+item.encode_file_id+'/small/404.png/100/272/208'"
                     :data-caption="item.description" :data-title="item.title" :id="'fullImageitem'+ item.encode_id" :data-image="link">
            </div>
            <div v-if="item.type==2 && item.files.length>0" class="height_225 back_gray">
                <video controls  width="100%" height="205" >
                    <source v-for="file in item.files" :src="'/LFM/DownloadFile/ID/'+file.encode_id" type="video/mp4">
                </video>
            </div>
            <div class="audio_parent_div height_225" v-if="item.type==1 && item.files.length>0" width="250" height="150">
                <audio class="audio_file" controls width="250" height="150">
                    <source v-for="file in item.files" :src="'/LFM/DownloadFile/ID/'+file.encode_id" type="video/mp4">
                </audio>
            </div>
            <div class="showContent">
                <div class="showOperateion">
                    <operation :item="item" type="image" model="gallery_item" pack="lgs"></operation>
                </div>
                <div class="showTitle">
                    <a class="pointer" @click="showItem"><h5 class="title_item_h">{{item.title}}</h5></a>
                </div>
            </div>
            <div class="showTags"><i class="fas fa-tags">
            </i><span>{{ t('tags') }}</span>
                <br>
            </div>
        </div>
    </div>
</template>

<script>
    import operation from './operation'
    import generateLoader from './generate_loader'
    export default {
        name: "image-style",
        props:['item','margin_el'],
        components:{
            operation,generateLoader
        },
        computed: {
            link: function () {
                return '/LFM/DownloadFile/ID/' + this.item.encode_file_id
            },
            showLoader:function () {
                return false ;
            }
        },
        methods:{
            showItem:function () {
                this.$parent.show_item_temp=true ;
                this.$parent.item=this.item ;
            }
        }
    }
</script>

<style scoped>

</style>