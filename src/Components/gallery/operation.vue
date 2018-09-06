<template>
    <div class="text-center" style="padding: 4px;margin: 2px -10px 2px -10px">
        <modal v-if="showModal" :src="src" @close="showModal = false"></modal>
        <div class="width_50 lgs_float_left lgs_text_left" style="height: 20px;line-height: 20px;">
            <div v-if="type =='gallery' || item.type == 0" class="lgs-icon fa-lgs-search-plus color_light_orange pointer showFullScreen lgs_float_left margin_right_4" @click="showModalFunc(link)"></div>
            <a class="lgs-icon fa-lgs-download color_blue_martina lgs_float_left margin_right_4" :href="link" target="_blank"></a>
            <visitable ref="visit" :model="model" :item ="item"></visitable>
        </div>
        <div class="width_50 lgs_float_left lgs_text_right">
          <likeable :model="model" :item ="item" :auth="auth" :pack="pack" :voted='item.voted' :type="type" :likes_count="item.likes_count" :dis_likes_count="item.dis_likes_count" ></likeable>
        </div>
        <div style="clear: both"></div>
    </div>
</template>

<script>
    import axios from '../lib/axios/index.js'
    import likeable from '../../laravel_likeable_system/laravel_likeable_system.vue'
    import visitable from '../../laravel_visitable/laravel_visitable_system.vue'
    import modal from './modal'
    export default {
        name: "operation",
        props: ['item','type','model','pack'],
        components :{
            likeable,visitable,modal
        },
        data: function () {
            return {
                auth : this.item.auth,
                showModal:false,
                src:''
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
            showModalFunc:function (e) {
                this.src = e
                this.showModal=true ;
            },
        }
    }

</script>

<style scoped>

</style>