<script setup>
    import { ref } from 'vue';

    const viewForm = ref(false);
    const nameClient = ref('');
    const cep = ref('');
    const address = ref('');
    const district = ref('');
    const number = ref('');
    const obs = ref('');

    const emit = defineEmits();

    function showForm(){
        viewForm.value = !viewForm.value;
    }

    function finish(){
        if(nameClient.value && address.value && district.value && number.value){
            let dataForm = {
                nameClient: nameClient.value, 
                address: address.value, 
                district: district.value, 
                number: number.value, 
                obs: obs.value
            }
            emit('finishOrder',dataForm);
        }else{
            alert('Preencha os campos obrigatórios!');
        }
    }

    async function searchCep(){
        let response = await fetch(`https://viacep.com.br/ws/${cep.value}/json/`);
        let data = await response.json();
        if(data.erro){
            alert('CEP incorreto, verifique!');
        }else{
            address.value = data.logradouro;
            district.value = data.bairro;   
        }
    }

</script>

<template>
    <div>
        <button class="fazer-pedido" v-on:click="showForm()">Finalizar Pedido</button>
        <div class="form-finish-order" v-if="viewForm">
            <h2>Finalize seu Pedido</h2>
            <div><input type="text" placeholder="Digite seu nome... *" v-model="nameClient"></div>
            <div>
                <input type="text" placeholder="CEP" v-model="cep">
                <button v-on:click="searchCep()"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div><input type="text" placeholder="Endereço * " v-model="address"></div>
            <div>
                <input type="text" placeholder="Bairro * " v-model="district">
                <input type="text" placeholder="Nº * " v-model="number">
            </div>
            <div><textarea placeholder="Observação..." v-model="obs"></textarea></div>
            <p>Campos com (*) são obrigatórios.</p>
            <button v-on:click="finish()">Fazer Pedido</button>
        </div>
    </div>
</template>

<style scoped>
    button{
        display: block;
        margin: 20px auto;
        padding: 10px 0;
        background-color: #111;
        color: #fff;
        border: none;
        width: 180px;
        font-size: 18px;
        border-radius: 10px;
    }
    button:active{
        transform: scale(0.9);
    }
    .form-finish-order{
        width: 98%;
        max-width: 500px;
        margin: 10px auto;
        border: 1px solid black;
        padding: 0 5px;
    }
    .form-finish-order div{
        display: flex;
        margin: 10px 0;
        gap: 5px;
    }
    .form-finish-order input{
        width: 100%;
        padding: 8px 5px;
    }
    .form-finish-order div button{
        width: 50px;
        background-color: #111;
        border-radius: 5px;
        color: #fff;
        border: none;
        margin: 0;
        padding: 0;
    }
    .form-finish-order input[placeholder="Nº"]{
        width: 100px;
    }
    .form-finish-order p{
        font-size: 14px;
        color: #555;
    }
    .form-finish-order textarea{
        width: 100%;
        height: 100px;
        resize: none;
        padding: 5px;
    }
</style>