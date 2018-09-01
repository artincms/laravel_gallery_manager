<template>
    <div class="text-center row">
        <div class="width_50 lgs_float_left lgs_text_left">
            <i v-if="type =='gallery' || item.type == 0" class="fas fa-search-plus color_light_orange pointer showFullScreen" :data-caption="item.description" :data-title="item.title" :id="'fullImage'+ item.encode_id" :data-image="link"></i>
            <a class="lgs-icon fa-lgs-download color_blue_martina" :href="link" target="_blank"></a>
            <visitable ref="visit" :model="model" :item ="item"></visitable>
        </div>
        <div class="width_50 lgs_float_left lgs_text_right">
          <likeable :model="model" :item ="item" :auth="auth"></likeable>
        </div>
    </div>
</template>

<script>
    import axios from '../../../../../../public/vendor/laravel_gallery_system/packages/axios/index.js'
    import likeable from '../../laravel_likeable_system/laravel_likeable_system.vue'
    import visitable from '../../laravel_visitable/laravel_visitable_system.vue'
    export default {
        name: "operation",
        props: ['item','type','model'],
        components :{
            likeable,visitable
        },
        data: function () {
            return {
                auth : this.item.auth
            }
            },
        computed: {
            increamentLike :
                {
                    get: function() {
                        return this.item.like ;
                    },
                    set: function(newValue) {
                        this.like=newValue
                    }
                },
            increamentDisLike :
                {
                    get: function() {
                        return this.item.dis_like ;
                    },
                    set: function(newValue) {
                        this.dis_like=newValue
                    }
                },
                link:function () {
                    if (this.type =='image')
                    {
                        if(this.item.type ==0)
                        {
                            return '/LFM/DownloadFile/ID/'+this.item.encode_file_id ;
                        }
                        else
                        {
                            return '/LFM/DownloadFile/ID/'+this.item.files[0].encode_id ;
                        }
                    }
                    else
                    {
                        return '/LFM/DownloadFile/ID/'+this.item.encode_file_id ;
                    }


                }
        },
        methods:{
            changeLike :function (encode_id,type,action) {
                console.log(encode_id,type,action);
                axios.post("/LGS/chnageLike", {encode_id: encode_id,type:type,action:action}).then(response => {
                    this.$nextTick(() =>{
                        this.increamentLike =response.data.like;
                        this.increamentDisLike=response.data.dis_like;
                    })
                })
            },
            showFullScreen:function (element) {
                console.log(element);
            },
            downloadFile:function () {

            }
        }
    }

</script>

<style scoped>

</style>