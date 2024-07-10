<script setup>
    import { ref, reactive, inject, onMounted } from 'vue';  

    const apiUrl = inject('apiUrl');
    const products = reactive({ 'prod': null });
    const showForm = ref(false);
    const selectedFiles = reactive({'img': null});
    const selectedProduct = ref(0);

    function toggleShow() {
        showForm.value = !showForm.value;
    }

    function handleFileChange(event) {
        selectedFiles.img = Array.from(event.target.files);
    }
    async function addImages() {
        const formData = new FormData();
        selectedFiles.img.forEach((file) => {
            formData.append('images[]', file);
        });

        formData.append('productId', selectedProduct.value);

        //try {
            let response = await fetch(`${apiUrl}`, {
                method: 'POST',
                body: formData
            });
            let result = await response.json();
            console.log(result)
        // } catch (error) {
        //     console.error('Error uploading images:', error);
        // }
    }

    async function getProducts() {
        let response = await fetch(`${apiUrl}produtos`);
        let data = await response.json();
        products.prod = data;
    }

    onMounted(() => {
        getProducts();
    });
</script>

<template>
    <div>   
        <div class="btn-showForm">
            <button v-if="!showForm" v-on:click="toggleShow()">Adicionar Fotos <i class="fa-solid fa-plus"></i></button>
            <button v-else v-on:click="toggleShow()">Fechar <i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="add-product" v-if="showForm">
            <h2>Adicionar Fotos do Produtos</h2>
            <div class="form">
                <select v-model="selectedProduct">
                    <option value="0">Selecione o produto</option>
                    <option v-for="product in products.prod" v-bind:key="product.id" :value="`${product.id}`">{{ product.nome }}</option>
                </select>
                <input type="file" multiple @change="handleFileChange">
                <button v-on:click="addImages">Adicionar</button>
            </div>
        </div>
    </div>
</template>


<style scoped>
    h2{
        font-size: 20px;
        font-weight: lighter;
    }
    .add-product{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 10px;
    }
    .add-product .form{
        width: 100%;
        max-width: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 10px;
        padding-bottom: 20px;
    }
    .add-product .form input{
        width: 100%;
        padding: 8px 5px;
        border: 1px solid #aaa;
        outline: none;
    }
    .add-product select{
        width: 100%;
        padding: 8px 0;
        text-align: center; border: 1px solid #aaa;
    }
    .add-product textarea{
        width: 100%;
        height: 100px;
        resize: none;
        outline: none;
        padding: 5px;
        border: 1px solid #aaa;
    }
    .add-product .form button{
        width: 150px;
        background-color: #804a1d;
        border: none;
        color: #fff;
        padding: 8px 0;
        border-radius: 5px;
    }
    .add-product .form button:active{
        transform: scale(0.98);
    }
    .btn-showForm{
        display: flex;
        justify-content: center;
        padding: 20px 0 5px 0;
    }
    .btn-showForm button{
        width: 150px;
        background-color: #804a1d;
        border: none;
        color: #fff;
        padding: 8px 0;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        gap: 10px;
        align-items: center;
        font-size: 15px;
    }
    .btn-showForm button{
        transform: scale(0.98);
    }
</style>