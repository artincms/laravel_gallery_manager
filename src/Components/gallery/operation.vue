<template>
    <div class="text-center row">
        <div class="width_50 float-left text-left">
            <i v-if="type =='gallery' || item.type == 0" class="fas fa-search-plus color_light_orange pointer showFullScreen" :data-caption="item.description" :data-title="item.title" :id="'fullImage'+ item.encode_id" :data-image="link"></i>
            <a class="fas fa-download color_blue_martina" :href="link" target="_blank"></a>
            <i class="far fa-eye color_blue"></i><span class="ml-1">{{item.visit}}</span>
        </div>
        <div class="width_50 float-left text-right">
          <likeable :model="'ArtinCMS\\LGS\\Model\\Gallery'" :item ="item" type="like"></likeable>
          <likeable :model="'ArtinCMS\\LGS\\Model\\Gallery'" :item ="item" type="disLike"></likeable>
        </div>
    </div>
</template>

<script>
    import axios from '../../../../../../public/vendor/laravel_gallery_system/packages/axios/index.js'
    import likeable from '../../laravel_likeable_system/laravel_likeable_system.vue'
    export default {
        name: "operation",
        props: ['item','type'],
        components :{
            likeable
        },
        data: function () {
            return {
                showModal :false
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
                            return '/LFM/DownloadFile/ID/'+this.item.encode_file_id[0] ;
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