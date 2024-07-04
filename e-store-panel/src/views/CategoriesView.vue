<script setup>
    import { inject, onMounted, reactive } from 'vue';
    import AddCategory from '@/components/add-category.vue';
    
    const apiUrl = inject('apiUrl');
    const showOptions = reactive({});
    const categories = reactive({})

    function toggleOptions(idProduto) {
        showOptions[idProduto] = !showOptions[idProduto];
    }

    async function obterCategorias(){
        let response = await fetch(`${apiUrl}categorias`);
        let data = await response.json();
        Object.assign(categories, data);
    }

    onMounted(()=>{
        obterCategorias();
    });

</script>

<template>
    <div>
        <h2 class="title">Gerencie as Categorias</h2>
        <AddCategory />
        <section class="view-categories">
            <h2>Categorias Adicionadas</h2>
            <div class="table" v-if="categories">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>CATEGORIA</th>
                        <th>IMAGEM</th>
                        <th>AÇÕES</th>
                    </tr>
                    <tr v-for="category in categories" v-bind:key="category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.categoria }}</td>
                        <td><img :src="`${apiUrl}images/img/categories/${category.imagem}`" alt="" srcset=""></td>
                        <td class="acoes">
                            <button v-on:click="toggleOptions(category.id)" v-if="!showOptions[category.id]"><i class="fa-solid fa-ellipsis"></i></button>
                            <button v-on:click="toggleOptions(category.id)" v-if="showOptions[category.id]"><i class="fa-solid fa-xmark"></i></button>
                            <div class="options" :style="showOptions[category.id] ? { display: 'block' } : { display: 'none' }">
                                <button v-on:click="toggleOptions(category.id)">Deletar <i class="fa-solid fa-trash"></i></button>
                                <button v-on:click="toggleOptions(category.id)">Editar <i class="fa-regular fa-pen-to-square"></i></button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div v-else>Nenhuma categoria foi adicionada!</div>
        </section>
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
    .view-categories {
        width: 100%;
        border-top: 2px solid #804a1d;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 10px;
    }
    .view-categories .table{
        width: 100%;
    }
    .view-categories .table table{
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
    table th{
        border: 1px solid black;
    }
    table tr{
        border-bottom: 1px solid black;
    }
    table td{
        text-align: center;
        padding: 2px 0;
    }
    table img{
        width: 50px;
    }
    table .acoes{
        width: 180px;
        position: relative;
    }
    table .acoes > button{
        font-size: 22px;
        width: 30px;
        background-color: #804a1d;
        color: #fff;
    }
    table .options{
        position: absolute ;
        top: -40px;
        left: -30px;
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