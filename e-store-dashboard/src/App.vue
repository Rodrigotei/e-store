<script setup> 
	import { RouterLink, RouterView, useRoute } from 'vue-router';
	import { computed, ref } from 'vue';
	import menubar from './components/menu-bar.vue'

	const route = useRoute();	
	const showBar = computed(()=> route.name !== 'login');

</script>

<template>
	<div>
		<menubar v-if="showBar"/>
		<div class="container-body">
			<RouterView></RouterView>
		</div>
	</div>
</template>