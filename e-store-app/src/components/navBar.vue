<script setup>

</script>

<template>

    <nav>
        <div class="logo">
            <img src="/img/logo.png" alt="" srcset="">
        </div>
        <div class="menu">
            <RouterLink to="/">Home</RouterLink>
            <RouterLink to="/">Sobre</RouterLink>
        </div>
    </nav>

</template>


<style scoped>
    nav{
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        background-color: #111111;
        min-height: 10vh;
        padding: 0 50px;
        border-bottom: 3px solid #fefed5;
    }
    nav .logo img{
        width: 180px;
    }
    nav .menu{
        width: 300px;
        display: flex;
        justify-content: space-around;
    }
    nav .menu a{
        color: #fefed5;
        text-decoration: none;
        font-size: 20px;
        font-family:'Times New Roman', Times, serif;
    }
    nav .menu a:hover{
        text-decoration: underline;
        color: #28aa98;
    }
    @media screen and (max-width: 600px) {
        nav{
            justify-content: center;
            padding: 0;
            flex-wrap: wrap;
            gap: 10px;
        }
        nav .menu{
            padding: 10px 0;
        }
    }
</style>
