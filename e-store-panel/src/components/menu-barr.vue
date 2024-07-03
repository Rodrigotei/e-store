<script setup>
    import { ref } from 'vue';
    import { RouterLink } from 'vue-router';

    const showMenu = ref(false);
    function openMenu(){
        showMenu.value = !showMenu.value; 
    }
    function exitDashboard(){
        document.cookie = 'logado=true; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        location.reload();
    }
</script>

<template>
    <div :class="['menu-barr', { 'expanded': showMenu }]">
        <div class="btn-menu" v-on:click="openMenu()">
            <p v-if="!showMenu"><i class="fa-solid fa-bars"></i></p>
            <p v-if="showMenu"><i class="fa-solid fa-xmark"></i></p>
        </div>
        <div v-if="showMenu">
            <div class="option"><RouterLink to="/">Home</RouterLink></div>
            <div class="option"><RouterLink to="/categories">Categorias</RouterLink></div>
            <div class="option"><RouterLink to="/products">Produtos</RouterLink></div>

            <div class="option exit" v-on:click="exitDashboard()">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></div>
        </div>
    </div>
</template>

<style scoped>
    .menu-barr{
        width: 50px;
        height: 100%;
        border-right: 2px solid #fff;
        border-top: 2px solid #fff;
        background-color: #3f2816;
        transition: 0.5s;
        padding: 0 10px;
    }
    .menu-barr.expanded{
        width: 300px;
        transition: 0.7s;
    }
    @media screen and (max-width: 600px){
        .menu-barr.expanded{
            position: absolute;
            top: 10vh;
            width: 90%;
            height: calc(100% - 10vh);
            z-index: 999;
            transition: 0.7s;
        }
    }
    .btn-menu{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px;
        font-size: 30px;
    }
    .btn-menu p{
        cursor: pointer;
        color: #fff;
    }
    .btn-menu p:active{
        transform: scale(0.9);
    }
    .option{
        border: 2px solid #fff;
        margin-bottom: 10px;
        padding: 8px;
        font-size: 16px;
        color: #fff;
    }
    .option:active{
        background-color: #777;
    }
    .option a{
        display: block;
        color: #fff;
        text-decoration: none;
    }
    .option.exit{
        position: absolute;
        bottom: 20px;
    }
</style>