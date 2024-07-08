<script setup>
    import { inject, reactive, watch } from 'vue';

    const apiUrl = inject('apiUrl');
    const productEdit = reactive({'name': null,'desc': null,'price':null, 'img': null, 'id': null});
    const newImg = reactive({'file': null});

    const emit = defineEmits(['closeEdit', 'upprod', 'messageStatus']);
    const props = defineProps({dataProductEdit: Object});
    
    function formatarDinheiro(input) {
    // Remove caracteres não numéricos
        let valor = input.target.value.replace(/\D/g, '');

        // Adiciona a vírgula como separador decimal
        valor = (valor / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2 });

        // Atualiza o valor no campo de entrada
        productEdit.price = valor;
    }

    function newImgCategory(event) {
        const file = event.target.files[0];
        newImg.file = file;
    }
    function closeForm(){
        emit('closeEdit');
    }

    async function updatdeProduct() {
        let response;
        if (newImg.file) {
            let form = new FormData();
            form.append('nameProduct', productEdit.name);
            form.append('priceProduct', productEdit.price);
            form.append('descProduct', productEdit.desc);
            form.append('imgProduct', newImg.file);
            form.append('idProduct', productEdit.id);

            response = await fetch(`${apiUrl}`, {
                method: 'POST',
                body: form
            });
        } else {
            let body = JSON.stringify({
                editProduct: true,
                nameProduct: productEdit.name,
                descProduct: productEdit.desc,
                priceProduct: productEdit.price,
                idProduct: productEdit.id
            });

            response = await fetch(`${apiUrl}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: body
            });            
        }
        let data = await response.json();
        emit('closeEdit');
        emit('upprod');
        emit('messageStatus', {color: 'blue', message: data});
    }

    watch(props.dataProductEdit, (newValue)=>{
        if(newValue){
            productEdit.name = newValue.name;
            productEdit.desc = newValue.desc;
            productEdit.price = newValue.price;
            productEdit.img = newValue.img;
            productEdit.id = newValue.id

        }
    }, {immediate: true});

</script>

<template>
    <div>
        <div class="form-edit">
            <h2>Editar Categoria</h2>
            <div><input type="text" placeholder="Nome da produto..." v-model="productEdit.name"></div>
            <div><input type="text" placeholder="Preço..." v-model="productEdit.price" v-on:input="formatarDinheiro"></div>
            <div><textarea placeholder="descrição do produto..." v-model="productEdit.desc"></textarea></div>
            <div class="img-atual">
                <p>Imagem atual</p>
                <img :src="`${apiUrl}images/img/produtos/${productEdit.img}`" alt="" srcset="">
            </div>
            <div><input type="file" v-on:change="newImgCategory"></div>
            <button class="btn-edit" v-on:click="updatdeProduct()">Atualizar</button>
            <button class="close" v-on:click="closeForm()"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
</template>

<style scoped>
    .form-edit{
        width: 100%;
        max-width: 500px;
        background-color: rgb(255, 255, 255);
        box-shadow: 0px 0px 5px black;
        border-radius: 5px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);text-align: center;
        padding: 10px;
    }
    h2{
        font-size: 22px;
        font-weight: lighter;
    }
    input{
        width: 100%;
        padding: 8px;
        outline: none;
        border: 1px solid black;
        margin: 10px 0;
    }
    .img-atual{
        padding: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid black;
    }
    .img-atual img{
        width: 50px;
    }
    .close{
        position: absolute;
        top: 0;
        right: 0;
        background-color: #3f2816;
        color: #fff;
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 18px;
    }
    .form-edit  textarea{
        width: 100%;
        height: 100px;
        resize: none;
        outline: none;
        padding: 5px;
        border: 1px solid #000;
    }
    .form-edit button.btn-edit{
        width: 150px;
        background-color: #804a1d;
        border: none;
        color: #fff;
        padding: 8px 0;
        border-radius: 5px;
    }
    .form-edit button.btn-edit:active{
        transform: scale(0.98);
    }
</style>