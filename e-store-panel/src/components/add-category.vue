<script setup>

</script>

<template>
    <div class="add-category">
        <h2>Adicionar Categoria</h2>
        <div class="form">
            <input type="text" placeholder="Nome da Categoria">
            <input type="file">
            <button>Adicionar</button>
        </div>
    </div>
</template>

<style scoped>
    h2{
        font-size: 20px;
        font-weight: lighter;
    }
    .add-category{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 10px;
    }
    .add-category .form{
        width: 100%;
        max-width: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 10px;
        padding-bottom: 20px;
    }
    .add-category .form input{
        width: 100%;
        padding: 8px 5px;
        border: 1px solid #aaa;
        outline: none;
    }
    .add-category .form button{
        width: 150px;
        background-color: #8e6e53;
        border: none;
        color: #fff;
        padding: 8px 0;
        border-radius: 5px;
    }
    .add-category .form button:active{
        transform: scale(0.98);
    }
</style>