<template>
    <div class="text-center row">
        <div class="col-lg-6 float-left text-left">
            <i class="fas fa-search-plus color_light_orange"></i>
            <i class="fas fa-download color_blue_martina"></i>
            <i class="far fa-eye color_blue"></i><span class="ml-1">{{item.visit}}</span>
        </div>
        <div class="col-lg-6 float-left text-right">
            <i class="far fa-thumbs-up color_red"></i><span class="ml-2">13</span>
            <i class="far fa-thumbs-down color_green"></i><span class="ml-2">12</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "operation",
        props: ['item'],
    }
</script>

<style scoped>

</style>