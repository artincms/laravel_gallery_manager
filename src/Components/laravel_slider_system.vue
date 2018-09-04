<template>
    <div id="app" class="ui container">
        <div class="ui grid">
            <div class="eleven wide column">
                <vue-flux v-if="setImages"  :options="fluxOptions" :images="fluxImages" :transitions="fluxTransitions" :captions="fluxCaptions" ref="slider">
                </vue-flux>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    window.axios = require('axios');
    import VueFlux from './slider/components/VueFlux.vue';
    import Transitions from './slider/components/transitions/index.js';
    // import swipe from '../../../../../public/vendor/laravel_gallery_system/packages/jquery_touch_swipe/jquery.touchSwipe.min.js';
    // import swipe_func from '../../../../../public/vendor/laravel_gallery_system/js/init_functions/init_touch_swipe.js';

    export default {
        name: 'laravel_slider_system',
        props:['slider_id','image_width','image_height'],
        components: {
            VueFlux
        },
        data: function () {
            return {
                fluxOptions: {
                    autoplay: true,
                },
                fluxImages: [],
                setImages :false ,
                fluxTransitions: {},
                fluxCaptions: [],
                rendered: false
            }
        },
        computed: {
            slider: function() {
                return this.$refs.slider;
            },

            currentTransition: function() {
                if (!this.rendered)
                    return undefined;

                return this.$refs.slider.transition.current;
            }
        },

        mounted() {
            this.rendered = true;
            this.getData();
        },
        methods: {
            getData : function () {
                axios.post("/LGS/Slider/getSliderItemFront", {slider_id: this.slider_id,image_width:this.image_width,image_height:this.image_height}).then(response => {
                    this.$nextTick(() =>{
                        this.fluxImages = response.data.url ;
                        this.fluxCaptions = response.data.captions ;
                        var trans =response.data.transiton ;
                        this.setTransition(trans);
                        if(response.data.options.show_arrow == '0')
                        {
                            this.fluxOptions.showControls = false ;
                        }
                        else {
                            this.fluxOptions.showControls = true ;
                        }

                        if(response.data.options.show_button == '0')
                        {
                            this.fluxOptions.showPagination = false ;
                        }
                        else {
                            this.fluxOptions.showPagination = true ;
                        }

                        if(response.data.options.transition_speed)
                        {
                            this.fluxOptions.delay = response.data.options.transition_speed ;
                        }

                        this.setImages =  true ;
                    });
                });
            },

            setTransition(trans) {
                switch(trans)
                {
                    case 'fluxTransitions':
                        this.fluxTransitions = {transitionFade: Transitions.transitionFade}
                        break;
                    case 'transitionSwipe':
                        this.fluxTransitions = {transitionSwipe: Transitions.transitionSwipe}
                        break;
                    case 'transitionSlide2d':
                        this.fluxTransitions = {transitionSlide2d: Transitions.transitionSlide2d}
                        break;
                    case 'transitionZip':
                        this.fluxTransitions = {transitionZip: Transitions.transitionZip}
                        break;
                    case 'transitionSlide3d':
                        this.fluxTransitions = {transitionSlide3d: Transitions.transitionSlide3d}
                        break;
                    case 'transitionBlinds2d':
                        break;
                    case 'transitionBlinds2d':
                        this.fluxTransitions = {transitionBlinds2d: Transitions.transitionBlinds2d}
                        break;
                    case 'transitionBlinds3d':
                        this.fluxTransitions = {transitionBlinds3d: Transitions.transitionBlinds3d}
                        break;
                    case 'transitionTurn3d':
                        this.fluxTransitions = {transitionTurn3d: Transitions.transitionTurn3d}
                        break;
                    case 'transitionBlocks2d1':
                        this.fluxTransitions = {transitionBlocks2d1: Transitions.transitionBlocks2d1}
                        break;
                    case 'transitionBlocks2d2':
                        this.fluxTransitions = {transitionBlocks2d2: Transitions.transitionBlocks2d2}
                        break;
                    case 'transitionBlocks3d':
                        this.fluxTransitions = {transitionBlocks3d: Transitions.transitionBlocks3d}
                        break;
                    case 'transitionConcentric':
                        this.fluxTransitions = {transitionConcentric: Transitions.transitionConcentric}
                        break;
                    case 'transitionWarp':
                        this.fluxTransitions = {transitionWarp: Transitions.transitionWarp}
                        break;
                    case 'transitionCamera':
                        this.fluxTransitions = {transitionCamera: Transitions.transitionCamera}
                        break;

                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import  './assets/css/vue_flux.css';
    h1.ui.header {
        margin-top: 18px;
    }
    .vue-flux {
        box-shadow: 0 0 12px 2px rgba(34,36,38,.85);
    }
</style>
