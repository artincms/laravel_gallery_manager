<template>
    <div class="show_item lgs_container ">
        <div>
            <div v-if="item.type ==0" class="img_parent_div">
                <img class="item_image" :src="link">
                <div class="back_to_par" @click="changGallery(item.encode_gallery_id)">
                    <i class="lgs-icon fa-lgs-level-up-alt" style="opacity: 0.4;"></i>
                </div>
                <div class="show_operation_item">
                    <operation :item="item" type="image" :model="'ArtinCMS\\LGS\\Model\\GalleryItem'"></operation>
                </div>
            </div>
            <div  class="img_parent_div" v-if="item.type == 1 && item.files.length>0">
                <audio class="audio_file_item" controls width="100%" height="150">
                    <source v-for="file in item.files" :src="'/LFM/DownloadFile/ID/'+file.encode_id" type="audio/mp3">
                </audio>
                <div class="show_operation_item_audio">
                    <operation :item="item" type="image" :model="'ArtinCMS\\LGS\\Model\\GalleryItem'"></operation>
                </div>
            </div>
            <div  class="img_parent_div" v-if="item.type == 2 && item.files.length>0">
                <video controls  width="100%" height="400" >
                    <source v-for="file in item.files" :src="'/LFM/DownloadFile/ID/'+file.encode_id" type="video/mp4">
                </video>
                <div class="show_operation_item">
                    <operation :item="item" type="image" :model="'ArtinCMS\\LGS\\Model\\GalleryItem'"></operation>
                </div>
            </div>
            <div class="show_item_content">
                <div class="showItemTitle">
                    <h5 class="lgs_h5 lgs_float_left"><span class="smaller-80">{{ t('title') }}</span></h5>
                    <p class="margin_right_20">{{this.item.title}}</p>
                    <div class="desc_item">
                        <h5 class="lgs_float_left margin_left_20 lgs_h5"><span class="smaller-80">{{ t('description') }}</span></h5>
                        <p class="" v-if="item.description">{{this.item.description}}</p>
                        <p class=""  v-else>-----</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="show_comment_system">
                <laravel_comments_system :target_model_name="'ArtinCMS\\LGS\\Model\\GalleryItem'" :target_id="item.encode_id" target_parent_column_name="encode_parent_id" :user-id="0" :show="true" :direction="direction" ></laravel_comments_system>
            </div>

        </div>
    </div>
</template>

<script>
    import operation from '../../laravel_gallery_system/gallery/operation.vue';
    import laravel_comments_system from '../../laravel_comment_system/laravel_comments_system.vue';
    export default {
        name: "show-item",
        props:['item','direction'],
        computed: {
            link:function () {
                if (this.item.type == 0) {
                    return '/LFM/DownloadFile/ID/' + this.item.encode_file_id+'/original/404.png/100/1400/400';
                }
                else {
                    return '/LFM/DownloadFile/ID/' + this.item.files[0].encode_id;
                }
            }
        },
        methods:{
            changGallery :function (parent_id) {
                this.$parent.getGallery(parent_id);
            }
        },
        components :{
            laravel_comments_system,operation
        }
    }
</script>

<style scoped>
.item_image {
    border: 1px solid #c1c1c1;
}
.show_operation_item {
    position: absolute;
    bottom: 0px;
    width: 100%;
    background: #00394dbd;
    padding: 5px;
}
.show_operation_item_audio {
    width: 100%;
    background: #00394dbd;
    padding: 5px;
}
.img_parent_div {
    position: relative;
}
.audio_file_item
{
    width: 100%;
    margin-top: 10px;
}
.show_item_content {
    padding: 10px;
    background-color: #f4f4f4;
    margin-top: 10px;
}

</style>