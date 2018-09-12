<template>
    <div class="total_loader">
        <div class="total_loader_content" style="">
            <div class="spinner_area">
                <div class="spinner_rects">
                    <div class="rect1"></div>
                    <div class="rect12"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
            <div class="text_area">لطفا منتظر بمانید</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "generateLoader"
    }
</script>

<style scoped>
    .total_loader {
        background-color: rgba(50, 50, 50, 0.7);
        color: #d9d9d9;
        font-weight: bolder;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        position: absolute;
        z-index: 50000;
    }

    .total_loader .total_loader_content {
        position: absolute;
        height: 140px;
        width: 100%;
        top: 50%;
        margin-top: -70px;
    }

    .total_loader .spinner_area {
        width: 50px;
        margin: 10px auto;
    }

    .total_loader .text_area {
        background-color: rgba(255, 255, 255, 0.8);
        color: #464646;
        text-align: center;
        padding: 10px 0;
    }
    .spinner_rects {
        /*margin: 100px auto;*/
        width: 50px;
        height: 40px;
        text-align: center;
        font-size: 10px;
    }

    .spinner_rects > div {
        background-color: #d9d9d9;
        height: 100%;
        width: 6px;
        display: inline-block;

        -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
        animation: sk-stretchdelay 1.2s infinite ease-in-out;
    }
    div#SysProcessGridData_filter {
        float: right;
    }
    .spinner_rects .rect2 {
        -webkit-animation-delay: -1.1s;
        animation-delay: -1.1s;
    }

    .spinner_rects .rect3 {
        -webkit-animation-delay: -1.0s;
        animation-delay: -1.0s;
    }

    .spinner_rects .rect4 {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .spinner_rects .rect5 {
        -webkit-animation-delay: -0.8s;
        animation-delay: -0.8s;
    }

    @-webkit-keyframes sk-stretchdelay {
        0%, 40%, 100% {
            -webkit-transform: scaleY(0.4)
        }
        20% {
            -webkit-transform: scaleY(1.0)
        }
    }

    @keyframes sk-stretchdelay {
        0%, 40%, 100% {
            transform: scaleY(0.4);
            -webkit-transform: scaleY(0.4);
        }
        20% {
            transform: scaleY(1.0);
            -webkit-transform: scaleY(1.0);
        }
    }
</style>