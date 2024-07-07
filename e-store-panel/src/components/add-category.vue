<script setup>
    import { ref, reactive, inject } from 'vue';  

    const apiUrl = inject('apiUrl');

    const nameCategory = ref('');
    const imgCategory = reactive({'file':null});

    const emit = defineEmits(['addCat', 'messageStatus']);

    function handleFileChange(event) {
        const file = event.target.files[0];
        imgCategory.file = file;
    }
    async function addCategory(){
        if(!nameCategory.value || !imgCategory.file){
            alert('Insira os dados corretamente');
            return false;
        }
        let form = new FormData();
        form.append('nameCategory', nameCategory.value);
        form.append('imgCategory', imgCategory.file);
        let response = await fetch(`${apiUrl}`,{
            method: 'POST',
            body: form
        })
        let data = await response.json();
        emit('addCat');
        emit('messageStatus', {color: '#1fb302', message: data});
        nameCategory.value = '';    
    }
</script>

<template>
    <div class="add-category">
        <h2>Adicionar Categoria</h2>
        <div class="form">
            <input type="text" placeholder="Nome da Categoria" v-model="nameCategory">
            <input type="file" v-on:change="handleFileChange">
            <button v-on:click="addCategory()">Adicionar</button>
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
        background-color: #804a1d;
        border: none;
        color: #fff;
        padding: 8px 0;
        border-radius: 5px;
    }
    .add-category .form button:active{
        transform: scale(0.98);
    }
</style>