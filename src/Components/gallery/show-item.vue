<template>
    <div class="show_item container">
        <div>
            <div v-if="item.type ==0" class="img_parent_div">
                <img :src="link">
            </div>
            <div class="show_operation_item">
                <operation :item="item" type="image" :model="'ArtinCMS\\LGS\\Model\\GalleryItem'"></operation>
            </div>
            <div class="show_comment_system">
                <laravel_comments_system :target_model_name="'ArtinCMS\\LGS\\Model\\GalleryItem'" :target_id="item.id" target_parent_column_name="parent_id" :user-id="0" :show="true" ></laravel_comments_system>
            </div>

        </div>
    </div>
</template>

<script>
    import operation from '../../laravel_gallery_system/gallery/operation.vue';
    import laravel_comments_system from '../../laravel_comment_system/laravel_comments_system.vue';
    export default {
        name: "show-item",
        props:['item'],
        computed: {
            link:function () {
                if (this.item.type == 0) {
                    return '/LFM/DownloadFile/ID/' + this.item.encode_file_id;
                }
                else {
                    return '/LFM/DownloadFile/ID/' + this.item.encode_file_id[0];
                }
            }
        },
        methods:{

        },
        components :{
            laravel_comments_system,operation
        }
    }
</script>

<style scoped>

</style>