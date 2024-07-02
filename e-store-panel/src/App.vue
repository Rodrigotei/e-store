<script setup>
	import { provide } from 'vue';
	import { RouterLink, RouterView } from 'vue-router'

	provide('apiUrl','http://localhost/e-store/e-store-api/')
	
</script>

<template>

	<div>
		<RouterView />
	</div>

</template>