<script setup>
    import {reactive, onMounted, nextTick } from 'vue';
    let lastProducts = reactive({'data': []});

    async function getLastProducts(){
        try{
            let response = await fetch('http://localhost/e-store/e-store-api/ultimosProdutos/');
            let data = await response.json();
            if(data.length > 0){
                lastProducts.data = data;
                await nextTick();
                initializeSwiper()
            }else{
                console.log('ERROR: API EMPTY');
            }
        }catch(error){
            console.log('ERROR: API NOT FOUND');
        }
    }
    onMounted(()=>{
       getLastProducts(); 
    });

    function initializeSwiper() {
        var swiper = new Swiper(".swiper", {
        slidesPerView: 2,
        spaceBetween: 10,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            640: {
            slidesPerView: 3,
            spaceBetween: 20,
            }
        },
        });
    }
</script>

<template>
    <div v-if="lastProducts.data && lastProducts.data.length > 3" class="body-last-prodicts">
        <h2>Adicionados Recentemente</h2>
        <div class="container-last-products">
        
            <div class="swiper">
                <div class="swiper-wrapper">
                    <router-link v-bind:to="'/productSingle/'+produto.id" class="last-produto-single swiper-slide" v-for="produto in lastProducts.data" v-bind:key="produto.id">
                        <img :src="'/img/produtos/'+ produto.img">
                        <p>{{ produto.nome }}</p>
                        <p><b>R$ {{ produto.preco }}</b></p>
                    </router-link>
                </div>
                <div class="swiper-pagination"></div>

            </div>

        </div>
    </div>
</template>

<style scoped>
    .body-last-prodicts{
        border-top: 2px solid rgb(51, 0, 237);
    }
    .container-last-products{
        width: 100%;
        max-width: 650px;
        margin: 0 auto;
        position: relative;
        padding: 0 10px;
    }
    .last-produto-single{
        padding: 5px;
        color: #000;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        flex-wrap: wrap;
        border: 1px solid #000;
    }
    .swiper {
      width: 100%;
      height: 100%;
      padding-bottom: 30px;
    }
    .swiper-slide {
      font-size: 18px;
      text-align: center;
    }
    .last-produto-single p:nth-of-type(2){
        border-top: 1px solid black;
        padding: 5px 0;
    }
    .last-produto-single:hover{
        filter: drop-shadow(10px 10px 10px #111);
    }
    .last-produto-single img{
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }
</style>
