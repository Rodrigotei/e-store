<script setup>
    import { ref, reactive, inject, onMounted } from 'vue';  

    const apiUrl = inject('apiUrl');

    const categories = reactive({'cat': null});

    const nameProduct = ref('');
    const imgProduct = reactive({'file':null});
    const idCategory = ref(0);
    const descProduct = ref('');
    const priceProduct = ref('');

    const emit = defineEmits(['addProd', 'messageStatus']);

    function handleFileChange(event) {
        const file = event.target.files[0];
        imgProduct.file = file;
    }
    function formatarDinheiro(input) {
    // Remove caracteres não numéricos
        let valor = input.target.value.replace(/\D/g, '');

        // Adiciona a vírgula como separador decimal
        valor = (valor / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2 });

        // Atualiza o valor no campo de entrada
        priceProduct.value = valor;
    }
    async function addProduct(){
        if(!nameProduct.value || !imgProduct.file || idCategory.value == 0){
            alert('Insira os dados corretamente');
            return false;
        }
        let form = new FormData();
        form.append('nameProduct', nameProduct.value);
        form.append('imgProduct', imgProduct.file);
        form.append('idCategory', idCategory.value);
        form.append('priceProduct', priceProduct.value);
        form.append('descProduct', descProduct.value);
        let response = await fetch(`${apiUrl}`,{
            method: 'POST',
            body: form
        })
        let data = await response.json();
        if(data !== 'Erro ao adicionar!'){
            emit('messageStatus', {color: '#1fb302', message: data});
            emit('addProd');
        }else{
            emit('messageStatus', {color: 'rgb(245, 21, 21)', message: data});
        }
        nameProduct.value = '';    
        idCategory.value = 0;
    }
    async function getCategories(){
        let response = await fetch(`${apiUrl}categorias`);
        let data = await response.json();
        categories.cat = data;
    }
    onMounted(()=>{
        getCategories();
    })
</script>

<template>
    <div class="add-product">
        <h2>Adicionar Produto</h2>
        <div class="form">
            <input type="text" placeholder="Nome do Produto" v-model="nameProduct">
            <select v-model="idCategory">
                <option value="0">Selecione a categoria</option>
                <option v-for="category in categories.cat" v-bind:key="category.id" :value="`${category.id}`">{{ category.categoria }}</option>
            </select>
            <input type="text" v-model="priceProduct" placeholder="Preço do produto" v-on:input="formatarDinheiro">
            <textarea v-model="descProduct" placeholder="Descrição do produto"></textarea>
            <input type="file" v-on:change="handleFileChange">
            <button v-on:click="addProduct()">Adicionar</button>
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
</style>