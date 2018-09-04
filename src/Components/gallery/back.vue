<template>
    <div class="main_gallery_div" :style="{margin:margin_el+ 'px'}">
        <div class="stack text-center" style="height: 100%;">
            <div @click="changeGallery(item.encode_parent_id)" class="height_225 pointer" style="height: 238px;position: relative;background-repeat: no-repeat;background-size: auto;height: 232px;
    background-position: center center" :class="{homeBack:!have_parent}">
                <div v-if="have_parent" class="thumb_zoom">
                    <img class="img_galleyr pointer" :src="link" alt="">
                </div>
                <div class="level_up pointer"><i class="lgs-icon fa-lgs-level-up-alt thumbnail_back" style="opacity: 0.4;"></i></div>
            </div>
            <div class="showContent">
                <div class="showOperateion">
                </div>
                <div class="showTitle">
                    <a class="pointer" @click="changeGallery(item.encode_parent_id)"><h5 class="title_item_h">{{ t('return') }}</h5></a>
                </div>
                <div class="showTags">
                    <p v-if="have_parent" style="text-align: center;">{{this.item.parrent.title}}</p>
                    <p v-else style="text-align: center;">خانه اصلی</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "gallery_back",
        props:['item','margin_el'],
        computed: {
            have_parent:function () {
                if(this.item.parrent)
                {
                    return true;
                }
                else
                {
                    return false ;
                }
            },
            link:function () {
                if(this.item.parrent)
                {
                    return '/LFM/DownloadFile/ID/' + this.item.parrent.encode_file_id +'/small/back.png/100/272/208'
                }
                else
                {
                    return '/LFM/DownloadFile/ID/0/small/back.png/100/272/208'
                }
            }
        },
        methods:{
            changeGallery :function (parent_id) {
                this.$parent.getGallery(parent_id);
            }
        },
    }
</script>

<style scoped>
span.level_up , div.level_up{
    font-size: 90px;
    color: #b3a8a8;
    width: 100%;
    height: 100%;
    background: #fffafade;
    position: absolute;
    right: 0px;
    text-align: center;
    padding-top: 50px;
    top: 0;
 }
    .showOperateion{
        min-height:23px;
    }
    .homeBack{
        background: repeating-linear-gradient(
                -55deg,
                #222,
                #222 10px,
                #333 10px,
                #333 20px
        );
    }
</style>