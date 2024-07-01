<script setup>
	import { RouterView, RouterLink } from 'vue-router';
	import { ref, onMounted } from 'vue';
	import { useGlobal } from './global';
	import NavBar from './components/navBar.vue';
	import FooterBar from './components/footerBar.vue';
	
	const GlobalVariables = useGlobal();

	const quantidadeCarrinho = ref(0);
	async function obterQuantidadeCarrinho(id){
		let response = await fetch(`${GlobalVariables.apiUrl}quantidadeCarrinho/${id}`);
		let data = await response.json();
		quantidadeCarrinho.value = data;
	}
	onMounted(()=>{
		obterQuantidadeCarrinho(localStorage.getItem('idUser'));
	});
	async function updateCart(){
		obterQuantidadeCarrinho(localStorage.getItem('idUser'));
	}
</script>

<template>
	<div>
		<NavBar />
		<main>
			<RouterView v-on:upcart="updateCart"/>
		</main>
		<div class="button-carrinho">
			<RouterLink to="/cart"><img :src="`${GlobalVariables.apiUrl}/images/img/cart.png`" alt="carrinho"></RouterLink>
			<p class="qtd-cart">{{ quantidadeCarrinho }}</p>
		</div>
		<FooterBar />
	</div>
</template>


<style scoped>
	main{
		min-height: 80vh;
		padding-bottom: 20px;
	}
	.button-carrinho{
		width: 60px;
		height: 60px;
		position: fixed;
		top: 80%;
		right: 20px;
		background-color: red;
		display: flex;
		justify-content: center;
		align-items: center;
		border-radius: 50%;
		border: 1px solid #28aa98;
		background-color: #111111;
		z-index: 999;
	}
	.button-carrinho img{
		width: 35px;
		filter: invert(1);
	}
	.button-carrinho .qtd-cart{
		position: absolute;
		top: -10px;
		right: -5px;
		background-color: #fefed5;
		border: 1px solid;
		border-radius: 50%;
		width: 22px;
		text-align: center;
	}
	.button-carrinho:hover{
		background-color: rgba(17, 17, 17, 0.8);
	}
</style>

