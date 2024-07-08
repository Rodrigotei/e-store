<script setup>
    import { onMounted, inject, reactive, ref } from 'vue';  
    import AddProduct from '@/components/add-products.vue';
    import EditProduct from '@/components/edit-product.vue';

    const apiUrl = inject('apiUrl');

    const showFormAdd = ref(false);
    const products = reactive({'prod':null});
    const showOptions = reactive({});

    const showEdit = ref(false);
    const productEdit = reactive({'name': null,'desc': null,'price':null, 'img': null, 'id': null});

    function toggleShowFormAdd(){
        showFormAdd.value = !showFormAdd.value;
    }
    function toggleOptions(idProduct) {
        showOptions[idProduct] = !showOptions[idProduct];
    }
    
    async function obterProdutos(){
        let response = await fetch(`${apiUrl}produtos`);
        let data = await response.json();
        // Object.assign(categories, data);
        products.prod = data;
    }
    
    async function deleteProduct(idProd){
        let response = await fetch(`${apiUrl}`,{
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({'deleteProd': true, 'idDelete': idProd})
        });
        let data = await response.json();
        obterProdutos();
        showMessageStatus('rgb(245, 21, 21)',data);
    }

    function showMessageStatus(color, message) {
        // Cria o elemento div
        const deleteMessage = document.createElement('div');
        deleteMessage.textContent = message;

        // Define os estilos
        deleteMessage.style.width = '300px';
        deleteMessage.style.position = 'absolute';
        deleteMessage.style.top = '15%';
        deleteMessage.style.right = '20px';
        deleteMessage.style.zIndex = '2';
        deleteMessage.style.backgroundColor = color;
        deleteMessage.style.textAlign = 'center';
        deleteMessage.style.padding = '15px 0';
        deleteMessage.style.color = '#fff';
        deleteMessage.style.borderRadius = '5px';

        // Adiciona o elemento ao corpo do documento
        document.body.appendChild(deleteMessage);

        // Remove o elemento após 3 segundos
        setTimeout(() => {
            deleteMessage.remove();
        }, 2000);
    }
    function showMessageAdd(data){
        showMessageStatus(data.color, data.message);
    }

    function showMessageEdit(data){
        showMessageStatus(data.color, data.message);
    }
    function openFormEdit(name,desc, price, img, id){
        productEdit.name = name;
        productEdit.desc = desc;
        productEdit.price = price;
        productEdit.img = img;
        productEdit.id = id
        showEdit.value = true;
        showOptions[id] = !showOptions[id];
    }
    function closeFormEdit(){
        showEdit.value = false;
    }

    onMounted(()=>{
        obterProdutos();
    })
</script>

<template>
    <div>
        <h2 class="title">Gerencie os Produtos</h2>
        <div class="btn-showForm">
            <button v-if="!showFormAdd" v-on:click="toggleShowFormAdd()">Adicionar produto <i class="fa-solid fa-plus"></i></button>
            <button v-else v-on:click="toggleShowFormAdd()">Fechar <i class="fa-solid fa-xmark"></i></button>
        </div>
        <AddProduct v-if="showFormAdd" @addProd="obterProdutos()" @messageStatus="showMessageAdd" />
        <section class="view-products">
            <h2>Categorias Adicionadas</h2>
            <div class="table" v-if="products">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>PRODUTO</th>
                        <th>PREÇO</th>
                        <th>DESCRIÇÃO</th>
                        <th>IMAGEM</th>
                        <th>AÇÕES</th>
                    </tr>
                    <tr v-for="product in products.prod" v-bind:key="product.id">
                        <td style="border-right: 1px solid black;">{{ product.id }}</td>
                        <td>{{ product.nome }}</td>
                        <td>{{ product.preco }}</td>
                        <td>{{ product.descricao }}</td>
                        <td><img :src="`${apiUrl}images/img/produtos/${product.img}`"></td>
                        <td class="acoes">
                            <button v-on:click="toggleOptions(product.id)" v-if="!showOptions[product.id]"><i class="fa-solid fa-ellipsis"></i></button>
                            <button v-on:click="toggleOptions(product.id)" v-if="showOptions[product.id]"><i class="fa-solid fa-xmark"></i></button>
                            <div class="options" :style="showOptions[product.id] ? { display: 'block' } : { display: 'none' }">
                                <button v-on:click="deleteProduct(product.id)">Deletar <i class="fa-solid fa-trash"></i></button>
                                <button v-on:click="openFormEdit(product.nome,product.descricao, product.preco, product.img, product.id)">Editar <i class="fa-regular fa-pen-to-square"></i></button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div v-else>Nenhuma categoria foi adicionada!</div>
        </section>
        <EditProduct v-if="showEdit" :data-product-edit="productEdit" v-on:closeEdit="closeFormEdit" 
                      v-on:upprod="obterProdutos" v-on:messageStatus="showMessageEdit"/>
    </div>
</template>

<style scoped>
    h2{
        font-size: 20px;
        font-weight: lighter;
    }
    .title{
        width: 100%;
        border-bottom: 2px solid red;
        padding-bottom: 5px;
        font-size: 22px;
        font-weight: lighter;
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
    /*------------------------------------ */
    .view-products {
        width: 100%;
        border-top: 2px solid #804a1d;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 10px;
    }
    .view-products .table{
        width: 100%;
    }
    .view-products .table table{
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
    table th{
        border: 1px solid black;
    }
    table tr{
        border-bottom: 1px solid black;
        min-height: 50px;
    }
    table td{
        text-align: center;
        padding: 2px 0;
        height: 50px;
    }
    table img{
        width: 50px;
    }
    table .acoes{
        width: 90px;
        position: relative;
    }
    table .acoes > button{
        font-size: 22px;
        width: 30px;
        background-color: #804a1d;
        color: #fff;
        border-radius: 5px;
    }
    table .options{
        position: absolute ;
        top: -40px;
        left: -70px;
        background-color: #fff;
        border: 1px solid black;
    }
    .options button{
        width: 100px;
        padding: 5px;
        display: flex;
        justify-content: space-between;
        background: transparent;
        border:  none;
        font-size: 16px;
    }
    .options button:active{
        background: #ccc;
    }
    .options button:nth-of-type(2){
        border-top: 1px solid black;
    }
</style>
