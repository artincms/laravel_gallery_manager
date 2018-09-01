<template>
    <div class="main_gallery_div" :style="{margin:margin_el+ 'px'}">
        <div class="stack text-center">
            <div @click="changeGallery(parent_id)" class="height_225">
                <span class="level_up pointer"><i class="lgs-icon fa-lgs-level-up-alt thumbnail_back"></i></span>
            </div>
            <div class="showContent">
                <div class="showOperateion">
                </div>
                <div class="showTitle">
                    <a class="pointer" @click="changeGallery(parent_id)"><h5 class="title_item_h">بازگشت</h5></a>
                </div>
                <div class="showTags"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "gallery_back",
        props:['parent_id','gallery_id','margin_el'],
        methods:{
            changeGallery :function (parent_id) {
                if(this.parent_id == this.gallery_id)
                {
                    this.$parent.showback=false ;
                }
                this.$parent.getGallery(parent_id);
            }
        }
    }
</script>

<style scoped>
span.level_up{
    font-size: 120px;
    color: #12cbc4;
}
    .showOperateion{
        min-height:23px;
    }
</style>