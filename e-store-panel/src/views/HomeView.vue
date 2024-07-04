<script setup>
    import { ref, onMounted, inject } from 'vue';
    import { RouterLink } from 'vue-router';

    const apiUrl = inject('apiUrl');

    const qtdClientes = ref(0)

    async function obterQtdClientsMensal(){
        let response = await fetch(`${apiUrl}qtdClientes`);
        let data = await response.json();
        qtdClientes.value = data;
    }

    onMounted(()=>{
        obterQtdClientsMensal();
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
            <p>Categorias Cadastradas: <b>10</b></p>
        </RouterLink>

        <RouterLink class="box" to="products">
            <p><i class="fa-solid fa-bag-shopping"></i></p>
            <p>Produtos Cadastrados: <b>10</b></p>
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