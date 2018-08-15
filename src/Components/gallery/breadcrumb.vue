<template>
    <div class="showBreadCrumb">
        <ol class="breadOl">
            <li class="item_bread" v-for="bread in breadCrumbs">
                <a target="_self" @click="changeGallery(bread.id)" href="#">{{bread.title}}</a>
            </li>
        </ol>
    </div>
</template>

<script>
    export default {
        name: "breadcrumb",
        props: ['item','gallery_id'],
        computed:{
            breadCrumbs:function () {
                if(this.item.encode_id)
                {
                    let id = this.item.encode_id;
                    let title = this.item.title;
                    let arr = {'id':id,'title':title};
                    let crump = this.$parent.crumb ;
                    let array = crump.map(x => {
                        return x.id;
                    })
                    let index = array.indexOf(id);
                    let length = crump.slice(index).length  ;
                    if(index ==-1)
                    {
                        crump.push(arr);
                    }
                    else
                    {
                        crump.splice(index+1,length);

                    }
                    if(this.item.encode_id == this.gallery_id)
                    {
                        this.$parent.showback=false ;
                    }
                    return crump;
                }
                else
                {
                    return [] ;
                }
            }
        },
        methods:{
            changeGallery :function (parent_id) {
                if(parent_id)
                {
                    this.$parent.getGallery(parent_id);
                }
            }
        }
    }
</script>

<style scoped>
    .breadOl {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding: 12px 16px;
        padding: .75rem 1rem;
        margin-bottom: 16px;
        margin-bottom: 1rem;
        list-style: none;
        background-color: #e9ecef;
        border-radius: .25rem;
    }
    ol {
        display: block;
        list-style-type: decimal;
        -webkit-margin-before: 1em;
        -webkit-margin-after: 1em;
        -webkit-margin-start: 0px;
        -webkit-margin-end: 0px;
        -webkit-padding-start: 40px;
    }
    .item_bread:after {
        display: inline-block;
        padding-right: 8px;
        padding-right: .5rem;
        color: #6c757d;
        content: "/";
    }
</style>