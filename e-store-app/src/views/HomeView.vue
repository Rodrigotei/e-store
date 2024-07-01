<script setup>
	import { onMounted } from 'vue';
	import { useGlobal } from '@/global';
	import Categories from '@/components/categories.vue';
	import LastProducts from '@/components/last-products.vue';
	
	const GlobalVariables = useGlobal()

	onMounted(() => {
	const bannerApp = document.querySelector('.banner-app');
	if (bannerApp) {
		bannerApp.style.setProperty('--bg-image-url', `url(${GlobalVariables.apiUrl}images/img/bg.jpeg)`);
	}
	});
</script>

<template>
	<div>
		<div class="banner-app">
			<h2>Catálogo Digital!</h2>
		</div>
		<Categories />	
		<LastProducts />
	</div>
</template>


<style scoped>

	.banner-app{
		width: 100%;
		height: 400px;
		background-color: #111111;
		background-image: var(--bg-image-url);
		background-repeat: no-repeat;
		background-size: cover;
		background-position: right;
		position: relative;
	}
	.banner-app h2{
		position:absolute;
		top:50%;
		left: 20%;
		transform:  translateY(-50%);
		width: 450px;
		background-color: rgba(17, 17, 17, 0.8);
		color: #fefed5;
		border-radius: 10px;
		font-size: 35px;
		text-align: center;
		padding: 20px 0;
	}
	@media screen and (max-width:700px) {
		.banner-app h2{
			left: 50%;
			transform:  translate(-50%, -50%);
		}
	}
	@media screen and (max-width:600px) {
		.banner-app h2{
			width: 90%;		
			font-size: 28px;
			padding: 20px 0;
		}
	}
	
</style>
