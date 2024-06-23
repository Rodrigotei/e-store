<script setup>
    import { useRoute } from 'vue-router';
    import { ref, onMounted, reactive } from 'vue';
    const route = useRoute();
    let idCategory = ref(route.params.categoryId);
    let products = reactive({'data': [],'erro': ''});

    async function getProducts(id){
        try{
            let response = await fetch(`http://localhost/e-store/e-store-api/categorias/${id}`);
            let data = await response.json();
            if(data.length > 0){
                products.data = data; 
            }else{
                products.data = [];
                products.erro = 'Nenhum produto foi encontrado!',
                console.log('ERROR: API EMPTY!');
            }
        }catch(error){
            console.log('ERROR: API NOT FOUND!');
        } 
    } 

    onMounted(()=>{
        getProducts(idCategory.value);
    })
</script>

<template>
<div>
    <div class="container-produtos" v-if="products.data && products.data.length > 0">
        
        <RouterLink class="produto-single" :to="'/productSingle/'+product.id"
            v-for="product in products.data" v-bind:key="product.id">
            <div class="img-produto"><img style="width: 90px;" :src="'/img/produtos/'+product.img" alt="img produto"></div>
            <div class="descricao-produto">
                <p>{{ product.nome }}</p>
                <p>{{ product.descricao }}</p>
                <p>R$ {{ product.preco }}</p>
            </div>
        </RouterLink>

    </div>

    <div v-else>
        <p style="text-align: center;">Nenhum produto encontrado!</p>
    </div>
</div>
</template>


<style scoped>
    .container-produtos{
        width: 100%;
        max-width: 1200px;
        padding: 5px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }
    .produto-single{
        width: 100%;
        max-width: 550px;
        border: 1px solid black;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        color: black;
    }
    .produto-single:hover{
        background-color: #000000cc;
        color: #fff;
    }
    .produto-single .img-produto{
        width: 100px;
        padding: 5px;
        border-right: 2px solid #111111;
    }
    .produto-single .descricao-produto{
        width: calc(100% - 100px);
        text-align: center;
        padding: 5px;
    }
    .descricao-produto p:nth-of-type(1){
        font-size: 17px;
        font-weight: bold;
        text-transform: capitalize;
        border-bottom: 1px solid #28aa98;
        padding: 5px 0;
    }
    .descricao-produto p:nth-of-type(2){
        font-size: 14px;
        text-align: justify;
        padding: 3px 0;
        border-bottom: 1px solid #28aa98;
    }
    .descricao-produto p:nth-of-type(3){
        font-size: 17px;
        font-weight: bold;
        text-transform: capitalize;
        padding: 5px 0 ;
    }
</style>