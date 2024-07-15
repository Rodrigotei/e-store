<script setup>
    import { useRoute } from 'vue-router';
    import { ref, onMounted, reactive, nextTick, watch } from 'vue';
    import { useGlobal } from '@/global';
    import lastProducts from '@/components/last-products.vue';
    import infProducts from '@/components/inf-product.vue';

    const GlobalVariables = useGlobal();

    const emit = defineEmits(['upcart']);
    const route = useRoute();
    let idProduct = ref(route.params.productId);
    let product = reactive({'data': [],'erro': ''});
    let imgProduct = reactive({'img': []});

    async function obterProduto(id){
        try{
            let response = await fetch(`${GlobalVariables.apiUrl}produtos/${id}`);
            let data = await response.json();
            if(data.length > 0){
                product.data = data[0]; 
                await nextTick();
                obterFotosProduto(idProduct.value);
                initializeSwiper();
            }else{
                product.data = [];
                product.erro = 'Nenhum produto foi encontrado!',
                console.log('ERROR: API EMPTY!');
            }
        }catch(error){
            console.log('ERROR: API NOT FOUND!');
        } 
    }
    async function obterFotosProduto(id){
        try{
            let response = await fetch(`${GlobalVariables.apiUrl}fotosProduto/${id}`);
            let data = await response.json();
            if(data.length > 0){
                imgProduct.img = data; 
            }
        }catch(error){
            console.log('ERROR: API NOT FOUND!');
        } 
    }

    function initializeSwiper(){
        var swiper = new Swiper(".mySwiper", {
            effect: "coverflow", grabCursor: true, centeredSlides: true, slidesPerView: "auto",
            coverflowEffect: { rotate: 50, stretch: 0, depth: 100, modifier: 1,slideShadows: true,},
            pagination: { el: ".swiper-pagination",},
        });
        nextTick(() => {
        var swiper = new Swiper(".mySwiper", {
            effect: "coverflow", 
            grabCursor: true, 
            centeredSlides: true, 
            slidesPerView: "auto",
            coverflowEffect: { 
                rotate: 50, 
                stretch: 0, 
                depth: 100, 
                modifier: 1,
                slideShadows: true,
            },
            pagination: { el: ".swiper-pagination", },
        });
    });
    }
    
    async function addCart(){
        try{
            let response = await fetch(`${GlobalVariables.apiUrl}`,{
                method: 'POST', 
                headers:{'Content-Type' : 'application/json'},
                body: JSON.stringify({'addCart':true, 'idProduct':product.data.id, 'idUser':localStorage.getItem('idUser')})
            });
            let data = await response.json();
            if(data){
                alert('Adicionado com sucesso!');
                emit('upcart');
            }
        }catch(err){
            console.log(err.message)
        }
    }
    onMounted(()=>{
        obterProduto(idProduct.value);
    });
    watch(()=>{return route.params.productId}, (newId) => {
        idProduct.value = newId;
        imgProduct.img = [];
        obterProduto(idProduct.value);
    });
</script>

<template>
    <div>
        <div class="container-produto-single" v-if="product.data">
            <div class="produto-view">
                <h2>{{ product.data.nome }}</h2>

                <div class="container-img-produto">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img :src="`${GlobalVariables.apiUrl}images/img/produtos/${product.data.img}`" />
                            </div>
                            <div class="swiper-slide" v-for="imgProduct in imgProduct.img" v-bind:key="imgProduct.id">
                                <img :src="`${GlobalVariables.apiUrl}images/img/produtos/${imgProduct.foto}`" />
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <p>R$ {{ product.data.preco }}</p>
                <p>{{ product.data.descricao }} Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem aliquid dolor atque soluta obcaecati dolorum! Unde, expedita ipsam iusto corporis hic ab autem, aut ratione ad vel minima sed nemo!</p>
                <button v-on:click="addCart()">Adicionar ao carrinho</button>
            </div>
        </div>
        <div v-else>
            <p>Erro ao receber os dados do produto!</p>
        </div>

        <infProducts v-bind:name-product="product.data.nome"/>

        <lastProducts />

    </div>
</template>


<style scoped>
    .produto-view{
        text-align: center;
        padding: 10px;
    }
    .produto-view h2{
        font-size: 23px;
        text-transform: capitalize;
    }
    .produto-view p{
        font-size: 17px;
        width: 95%;
        max-width: 800px;
        margin: 0 auto;
        margin-top:20px;
    }
    .produto-view p:nth-of-type(1){
        background-color: #111;
        color: #fff;
        padding: 3px 0;
        width: 200px;
        margin: 0 auto;
        font-size: 20px;
        margin-top: 10px;
    }
    .container-img-produto{
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
    }
    .swiper {
        width: 100%;
        padding-top: 5px;
        padding-bottom: 50px;
    }
    .swiper-slide {
      background-size: contain;
      width: 350px;
      height: 200px;
    }
    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
    }
    @media screen and (max-width: 900px){
        .swiper-slide{
            width: 300px;
            height: 150px;
        }
    }
    button{
        background-color: #111;
        color: #fff;
        width: 220px;
        padding: 10px 0;
        border: none;
        margin-top: 20px;
        font-size: 18px;
        border-radius: 10px;
    }
    button:active{
        transform: scale(0.9);
    }
</style>