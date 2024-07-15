<script setup>
    import { ref, watch } from 'vue';
    import { useRoute } from 'vue-router';
    import { useGlobal } from '@/global';

    const GlobalVariables = useGlobal();

    const route = useRoute();
    let showForm = ref(false);
    let nameUser = ref('');
    let mensageUser = ref('');
   
    const nameProduct = defineProps({nameProduct: String});

    function openForm(){
        showForm.value = true;
    }
   
    function mensageAbout(){
        const number = GlobalVariables.numberPhone;
        if(nameUser.value.length > 0 && mensageUser.value.length > 0){
            let nome = nameUser.value.trim();
            let mensagem = mensageUser.value.trim();
            let mensagemTotal = `Olá, RT.CODE.%0ASou *${nome}*%0AMensagem: _${encodeURIComponent(mensagem)}_%0A*Produto*: ${encodeURIComponent(nameProduct.nameProduct)}`;
            window.open(`https://wa.me/${number}?text=${mensagemTotal}`);
        }else{
            alert('Preencha corretamente antes de enviar!');
        }
    }
    
    watch(() => route.params.productId, () => {
            showForm.value = false
        }
    );
</script>

<template>
    <div class="container-inf-product">
        <button style="background-color: #28aa98; color: #000;" v-on:click="openForm();">Saiba mais!</button>
        <div class="form-product" v-if="showForm">
            <h2>Entre em contato</h2>
            <input type="text" id="nome-client" placeholder="Digite seu nome..." v-model="nameUser">
            <textarea id="mensage-client" placeholder="Digite sua mensagem..." v-model="mensageUser"></textarea>
            <button style="margin-top: 0;" v-on:click="mensageAbout()">Enviar</button>
        </div>
    </div>
</template>

<style scoped>
.container-inf-product{
    padding: 10px 0 ;
}
    .form-product{
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        margin-top: 20px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 20px;
        padding: 10px;
    }
    .form-product h2{
        padding: 0;
    }
    .form-product input{
        padding: 5px;
        font-size: 16px;
    }
    .form-product textarea{
        padding: 5px;
        font-size: 16px;
        resize: none;
        height: 100px;
    }
    button{
        background-color: #111;
        color: #fff;
        width: 220px;
        padding: 10px 0;
        border: none;
        margin: 0 auto;
        margin-top: 20px;
        font-size: 18px;
        border-radius: 10px;
        display: block;
    }
    button:active{
        transform: scale(0.9);
    }
</style>