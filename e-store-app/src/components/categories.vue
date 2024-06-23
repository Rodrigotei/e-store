<script setup>
    import { onMounted, reactive } from 'vue';
    
    //metodo para alterar o objeto usando o reactive POG
    let categories = reactive({'data': []});
    async function getCategories() {
        try{
            let response = await fetch('http://localhost/e-store/e-store-api/categorias/');
            let data = await response.json();
            if(data.length > 0){
                setTimeout(()=>{
                    categories.data = data;
                },10);
            }else{
                console.log('ERROR: API EMPTY');
            }
        }catch(error){
            console.log('ERROR: API NOT FOUND');
        }
    }
    onMounted(()=>{
        getCategories();
    });

</script>

<template>
   <div>
        <h2>Nossas Categorias</h2>
        
        <div class="container-categories" v-if="categories.data && categories.data.length > 0">  
            <router-link v-bind:to="'/products/' + categoria.id" class="categoria-single" 
                        v-for="categoria in categories.data" :key="categoria.id">
                <img style="width: 120px;" :src="'img/categories/'+ categoria.imagem" alt="" srcset="">
                <p>{{ categoria.categoria }}</p>
            </router-link>
        </div>    
        <div v-else>
            <p>Nenhuma categoria foi encontrada!</p>
        </div> 
   </div>
</template>

<style scoped>
    .container-categories{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
        max-width: 750px;
        width: 95%;
        margin: 0 auto;
    }
    .categoria-single{
        display: block;
        padding: 5px;
        color: #000;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        flex-wrap: wrap;
        gap: 5px;
        position: relative;
    }
    .categoria-single:hover{
        filter: drop-shadow(10px 10px 10px #111);
    }
    .categoria-single img{
        width: 120px;
        height: 120px;
        border-radius: 50%;
    }
</style>