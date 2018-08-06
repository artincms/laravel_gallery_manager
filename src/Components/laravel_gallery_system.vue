<template>
    <div id="app" class="ui container">
        <div class="ui grid">
            <div class="eleven wide column">
                <vue-flux v-if="setImages"  :options="fluxOptions" :images="fluxImages" :transitions="fluxTransitions" :captions="fluxCaptions" ref="slider">
                    <!--<template slot-scope="paginationItem" slot="paginationItem">{{ paginationItem.index }}</template>-->
                    <!--<template slot="controls">
                        <span @click="slider.showImage('previous')">PREVIOUS</span>
                        <span @click="slider.toggleAutoplay()">TOGGLE</span>
                        <span @click="slider.showImage('next')">NEXT</span>
                    </template>-->
                </vue-flux>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueFlux from './components/VueFlux.vue';
    import Transitions from './components/transitions/index.js';

    export default {
        name: 'laravel_gallery_system',
        props:['slider_id'],
        components: {
            VueFlux
        },
        data: function () {
            return {
                fluxOptions: {
                    autoplay: true,
                    showPagination: true,
                    showControls: true
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
        beforeMount() {

        },
        mounted() {
            this.rendered = true;
            this.getData();
        },
        methods: {
            getData : function () {
                axios.post("/LGS/Slider/getSliderItemFront", {slider_id: this.slider_id}).then(response => {
                    this.$nextTick(() =>{
                        this.fluxImages = response.data.url ;
                        this.fluxCaptions = response.data.captions ;
                        var trans =response.data.transiton ;
                        console.log(response.data.transiton);
                        this.fluxTransitions = {transition:Transitions.transitionFade};
                        this.setImages =  true ;
                    });
                });
            },

            setTransition(transition) {
                return this.currentTransition === transition? 'active' : '';
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import  '../../../../../public/vendor/laravel_gallery_system/css/vue_flux.css';
    h1.ui.header {
        margin-top: 18px;
    }

    .vue-flux {
        box-shadow: 0 0 12px 2px rgba(34,36,38,.85);
    }
</style>
