<template>
	<flux-vortex :slider="slider" :num-circles="numCircles" :index="index" ref="vortex"></flux-vortex>
</template>

<script>
	import FluxVortex from '../FluxVortex.vue';

	export default {
		components: {
			FluxVortex
		},

		data: () => ({
			index: undefined,
			numCircles: undefined,
			radius: 90,
			tileDuration: 400,
			totalDuration: 0,
			easing: 'ease',
			tileDelay: 80,
		}),

		props: {
			slider: Object,
			direction: String
		},

		computed: {
			vortex: function() {
				return this.$refs.vortex;
			}
		},

		created() {
			this.index = this.slider.currentImage.index;

			let size = this.slider.size;

			let diag = Math.sqrt(Math.pow(size.width, 2) + Math.pow(size.height, 2));
			this.numCircles = Math.ceil(diag / 2 / this.radius) + 1;

			this.totalDuration = this.tileDelay * this.numCircles + this.tileDuration;
		},

		mounted() {
			this.slider.currentImage.hide();

			this.vortex.setCss({
				overflow: 'hidden'
			});

			this.vortex.transform((circle, i) => {
				circle.transform({
					transition: 'all '+ this.tileDuration +'ms '+ this.easing +' '+ this.getDelay(i) +'ms',
					opacity: '0',
					transform: 'scale(0, 0)'
				});
			});
		},

		methods: {
			getDelay(i) {
				return i * this.tileDelay;
			}
		}
	};
</script>
