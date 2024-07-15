<script setup>
    import { ref, onMounted, inject } from 'vue';
    import { RouterLink } from 'vue-router';

    const apiUrl = inject('apiUrl');

    const qtdClientes = ref(0);
    const qtdCategorias = ref(0);
    const qtdProdutos = ref(0);
    const qtdFotosAdicionais = ref(0);

    async function obterQtdClientsMensal(){
        let response = await fetch(`${apiUrl}qtdClientes`);
        let data = await response.json();
        qtdClientes.value = data;
    }
    async function obterQtdCategorias(){
        let response = await fetch(`${apiUrl}qtdCategorias`);
        let data = await response.json();
        qtdCategorias.value = data.length;
    }
    async function obterQtdProdutos(){
        let response = await fetch(`${apiUrl}qtdProdutos`);
        let data = await response.json();
        qtdProdutos.value = data.length;
    }
    async function obterQtdFotosAdicionais(){
        let response = await fetch(`${apiUrl}qtdFotosAdicionais`);
        let data = await response.json();
        qtdFotosAdicionais.value = data.length;
    }

    onMounted(()=>{
        obterQtdClientsMensal();
        obterQtdCategorias();
        obterQtdProdutos();
        obterQtdFotosAdicionais();
    });
</script>
    
<template>
    <div class="container">
        <RouterLink class="box" to="/">
            <p><i class="fa-solid fa-users"></i></p>
            <p>Acessos Mensal: <b>{{ qtdClientes }}</b></p>
        </RouterLink>

        <RouterLink class="box" to="/categories">
            <p><i class="fa-solid fa-layer-group"></i></p>
            <p>Categorias Cadastradas: <b>{{ qtdCategorias }}</b></p>
        </RouterLink>

        <RouterLink class="box" to="/products">
            <p><i class="fa-solid fa-bag-shopping"></i></p>
            <p>Produtos Cadastrados: <b>{{ qtdProdutos }}</b></p>
        </RouterLink>

        <RouterLink class="box" to="/imgAdd">
            <p><i class="fa-regular fa-image"></i></p>
            <p>Imagens Adicionais: <b>{{ qtdFotosAdicionais }}</b></p>
        </RouterLink>
    </div>
</template>

<style scoped>
    .container{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        flex-direction: column;
    }
    .container .box{
        width: 300px;
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        align-items: center;
        background: rgb(139, 96, 27);
        color: #fff;
        padding: 0 15px;
        height: 90px;
        border-radius: 5px;
        text-decoration: none;
    }
    .box p:nth-of-type(1){
        font-size: 30px;
    }
</style>