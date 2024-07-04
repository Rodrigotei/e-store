<script setup>
	import { inject } from 'vue';
	import { RouterView } from 'vue-router';
	import NavBar from '@/components/nav-bar.vue';
	import MenuBarr from '@/components/menu-barr.vue';
</script>

<template>
	<main>
		<NavBar />
		<div class="container-body">
			<div class="menu-barr"><MenuBarr /></div>
			<div class="content">
				<Router-view />
			</div>
		</div>
	</main>
</template>

<style scoped>
	.container-body{
		width: 100%;
		height: 90vh;
		display: flex;
	}
	.content{
		padding: 10px;
		width: 100%;
		height: 100%;
		overflow-y: auto;
	}
</style>
