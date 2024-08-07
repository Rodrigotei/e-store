<script setup>
    import { inject, onMounted, reactive, ref } from 'vue';
    import AddImg from '@/components/add-img-product.vue';

    const apiUrl = inject('apiUrl');
    const products = reactive({'prod': null, 'img': null});
    const showViewImg = ref(false);
    const urlViewFullImg = ref('');
    const showOptions = reactive({});

    async function obterProdutos(){
        let res = await fetch(`${apiUrl}/produtos`);
        let data = await res.json();
        products.prod = data;
    }
    async function obterFotosProduto(id){
        products.img = null;
        let res = await fetch(`${apiUrl}/qtdFotosAdicionais/${id}`);
        let data = await res.json();
        if(data.length > 0){
            products.img = data;
        }
    }

    function showImg(img){
        showViewImg.value = true;
        urlViewFullImg.value = `${apiUrl}/images/img/produtos/${img}`;
    }
    function closeShowImg(){
        showViewImg.value = !showViewImg.value
    }
    function toggleOptions(event, id){
        event.stopPropagation();
        showViewImg.value = false;
        showOptions[id] = !showOptions[id];
    }
    async function deleteProduct(event, id, id_produto){
        event.stopPropagation();
        let response = await fetch(`${apiUrl}`,{
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({'deleteImg':true, 'idImg': id})
        });
        let data = await response.json();
        showMessageStatus('rgb(245, 21, 21)',data);
        setTimeout(()=>{
            obterFotosProduto(id_produto);
        }, 1000);
    }
    function insertImg(data){
        showMessageStatus(data.color ,data.message);
        setTimeout(()=>{
            obterFotosProduto(data.id_product);
        }, 1000);
    }
    function showMessageStatus(color, message) {
        // Cria o elemento div
        const deleteMessage = document.createElement('div');
        deleteMessage.textContent = message;

        // Define os estilos
        deleteMessage.style.width = '330px';
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
    onMounted(()=>{
        obterProdutos();
    });

</script>

<template>
    <div class="container">
        <h2>Gerencie as Fotos dos Produtos</h2>
        <AddImg @insert-img="insertImg"/>  
        <div class="products">
            <h2>Escolha o Produto</h2>
            <div class="product-single" v-for="product in products.prod" v-bind:key="product.id" v-on:click="obterFotosProduto(product.id)">
                <p>{{ product.nome }}</p>
                <img :src="`${apiUrl}/images/img/produtos/${product.img}`" alt="">
            </div>
        </div>
        <div class="container-view-img-add">
            <h2>Fotos dos Produtos</h2>
            <div class="view-img-add" v-if="products.img != []">
                <div class="img-single" v-for="img in products.img" v-bind:key="img.id" v-on:click="showImg(img.foto)">
                    <img :src="`${apiUrl}/images/img/produtos/${img.foto}`">
                    <button v-on:click="toggleOptions($event, img.id)" v-if="!showOptions[img.id]"><i class="fa-solid fa-ellipsis"></i></button>
                    <button v-on:click="toggleOptions($event, img.id)" v-if="showOptions[img.id]"><i class="fa-solid fa-xmark"></i></button>
                    <div class="options" :style="showOptions[img.id] ? { display: 'block' } : { display: 'none' }">
                        <button v-on:click="deleteProduct($event, img.id, img.id_produto)">Deletar <i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="view-img-full" v-if="showViewImg">
            <img :src="`${urlViewFullImg}`" alt="">
            <button class="close-view" v-on:click="closeShowImg"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
</template>

<style scoped>
    .container{
        width: 100%;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    .container > h2{
        font-size: 20px;
        font-weight: lighter;
        width: 100%;
        border-bottom: 2px solid red;
        padding-bottom: 5px;
        font-size: 22px;
        font-weight: lighter;
    }   
    .products{
        width: 95%;
        max-width: 600px;
        height: 300px;
        overflow: auto;
        padding: 0 10px;
    }
    .products > h2{
        text-align: center;
        font-weight: lighter;
    }
    .products .product-single{
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid black;
        margin: 5px 0;
        padding: 2px 10px;
        border-radius: 5px;
    }
    .products .product-single:hover{
        background-color: #ddd;
    }
    .products .product-single:active{
        transform: scale(0.98);
    }
    .product-single img{
        width: 50px;
    }
    .container-view-img-add{
        width: 100%;
        border-top: 2px solid #804a1d;
    }
    .container-view-img-add h2{
        text-align: center;
        font-size: 22px;
        font-weight: lighter;
    }
    .view-img-add{
        width: 100%;
        overflow-x: auto;
        display: flex;
        justify-content: start;
        align-items: center;
        gap: 20px;
        padding: 20px;
        box-sizing: border-box;
    }
    .img-single{
        width: 200px;
        height: 150px;
        background-color: #ddd;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px;
        border-radius: 5px;
        position: relative;
        flex-shrink: 0; /* Evita que os itens encolham */

    }
    .view-img-add img{
        width: 100%;
        max-height: 100%;
    }
    .view-img-full{
        width: 100%;
        max-width: 600px;
        height: 60vh;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        background: white;
        box-shadow: 0px 0px 10px black;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .view-img-full img{
        width: 100%;
        max-height: 60vh;
    }
    .close-view{
        width: 25px;
        font-size: 18px;
        position: absolute;
        top: 0;
        right: 0;
        background-color: white;
        color: black;
    }

    .options{
        position: absolute;
        top: -20px;
        right: 27px;
    }
    .options button{
        padding: 3px 2px;
        font-size: 16px;
    }
    .img-single > button{
        position: absolute;
        top: 0;
        right: 0;
        width: 25px;
        font-size: 16px;
    }
</style>