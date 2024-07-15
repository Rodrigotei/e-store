<script setup>

	import { inject, ref } from "vue";
	
	const user = ref('');
	const password = ref('');

	const apiUrl = inject('apiUrl');

	async function acessarConta(){
		let response = await fetch(`${apiUrl}`,{
			method: 'POST',
			headers: {'Content-Type': 'application/json'},
			body: JSON.stringify({'authenticate': true, 'user': user.value, 'pass': password.value})
		});
		let data = await response.json();
		if(data){
			const successMessage = document.createElement('div');
            successMessage.textContent = 'Entrando...';
            successMessage.style.position = 'absolute';
            successMessage.style.top = '10%';
            successMessage.style.left = '50%';
            successMessage.style.transform = 'translateX(-50%)';
            successMessage.style.color = '#fff';
            successMessage.style.backgroundColor = 'rgb(25, 158, 25)';
            successMessage.style.padding = '15px 0';
            successMessage.style.width = '300px';
            successMessage.style.textAlign = 'center';
            successMessage.style.fontSize = '16px';
            successMessage.style.borderRadius = '10px';
            document.body.appendChild(successMessage);
			setTimeout(()=>{
				let data = new Date();
    			data.setTime(data.getTime() + (60 * 1000 * 60));
				let dateExpire =    data.toUTCString();
    			document.cookie = 'logado=true; expires= '+dateExpire;				
				successMessage.remove()
				location.href = '/estoredashboard';
			}, 2000);
		}else{
			const errorMessage = document.createElement('div');
            errorMessage.textContent = 'Usuário ou senha incorretos!';
            errorMessage.style.position = 'absolute';
            errorMessage.style.top = '10%';
            errorMessage.style.left = '50%';
            errorMessage.style.transform = 'translateX(-50%)';
            errorMessage.style.color = '#fff';
            errorMessage.style.backgroundColor = 'rgb(243, 37, 37)';
            errorMessage.style.padding = '15px 0';
            errorMessage.style.width = '300px';
            errorMessage.style.textAlign = 'center';
            errorMessage.style.fontSize = '16px';
            errorMessage.style.borderRadius = '10px';
            document.body.appendChild(errorMessage);
			setTimeout(()=>{
				errorMessage.remove()
			}, 2000);
		}
	}

</script>

<template>
	<div class="container-login">
		<div class="form">
			<div class="logo">
				<img style="width: 200px;" :src="`${apiUrl}images/img/logo.png`" alt="" srcset="">
			</div>
			<div class="input-group">
				<input type="text" placeholder="usuário..." v-model="user"/>
			</div>
			<div class="input-group">
				<input type="password" placeholder="senha..." v-model="password"/>
			</div>
			<div>
				<button v-on:click="acessarConta()">Entrar</button>
			</div>
		</div>
	</div>
</template>

<style>
	.container-login {
		display: flex;
		justify-content: center;
		align-items: center;
		width: 100vw;
		height: 100vh;
		background: linear-gradient(135deg, #c28150, #3f2816);
	}

	.form {
		display: flex;
		flex-direction: column;
		align-items: center;
		padding: 2rem ;
		border-radius: 8px;
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
		background: white;
		max-width: 400px;
		width: 100%;
		gap: 1rem;
	}
	.logo{
		width: 100%;
		background-color: #633a1b;
		display: flex;
		justify-content: center;
		align-content: center;
		padding: 5px 0;
		border-radius: 4px;
	}
	.input-group {
		width: 100%;
	}

	input[type="text"],
	input[type="password"] {
		width: 100%;
		padding: 0.75rem;
		margin-bottom: 0.5rem;
		border: 1px solid #754225;
		border-radius: 4px;
		box-sizing: border-box;
		outline: none;
	}

	input[type="text"]::placeholder,
	input[type="password"]::placeholder {
		color: #999;
	}

	button {
		width: 120px;
		padding: 0.75rem;
		border: none;
		border-radius: 4px;
		background-color: #8e6e53;
		color: white;
		font-size: 1rem;
		cursor: pointer;
		transition: background-color 0.3s ease;
	}

	button:hover {
		background-color: #754225;
	}
</style>
