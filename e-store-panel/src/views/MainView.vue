<script setup>
	import { inject } from 'vue';
	import { RouterView } from 'vue-router';
	const apiUrl = inject('apiUrl');
</script>

<template>
	<main>
		<h1>MAIN VIEW</h1>
		<Router-view />
	</main>
</template>
