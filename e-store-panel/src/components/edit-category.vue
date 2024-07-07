<script setup>
    import { inject, reactive, ref, watch } from 'vue';

    const apiUrl = inject('apiUrl');
    const nameCategory = ref('');
    const nameImg = ref('');
    const idcategory = ref('');
    const newImg = reactive({'file': null});

    const emit = defineEmits(['closeEdit', 'upcat', 'messageStatus']);
    const props = defineProps({categoryEdit: Object});
    
    function newImgCategory(event) {
        const file = event.target.files[0];
        newImg.file = file;
    }
    function closeForm(){
        emit('closeEdit');
    }

    async function updatdeCategory() {
        let response;
        if (newImg.file) {
            let form = new FormData();
            form.append('nameCategory', nameCategory.value);
            form.append('idCategory', idcategory.value);
            form.append('newImgCategory', newImg.file);

            response = await fetch(`${apiUrl}`, {
                method: 'POST',
                body: form
            });
        } else {
            let body = JSON.stringify({
                editCategory: true,
                nameCategory: nameCategory.value,
                idCategory: idcategory.value
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
        emit('upcat');
        emit('messageStatus', {color: 'blue', message: data});
    }

    watch(props.categoryEdit, (newValue)=>{
        if(newValue){
            nameCategory.value = newValue.name;
            nameImg.value = newValue.img;
            idcategory.value = newValue.id;
        }
    }, {immediate: true});

</script>

<template>
    <div>
        <div class="form-edit">
            <h2>Editar Categoria</h2>
            <div><input type="text" placeholder="Nome da categoria..." v-model="nameCategory"></div>
            <div class="img-atual">
                <p>Imagem atual</p>
                <img :src="`${apiUrl}images/img/categories/${nameImg}`" alt="" srcset="">
            </div>
            <div><input type="file" v-on:change="newImgCategory"></div>
            <button class="btn-edit" v-on:click="updatdeCategory()">Atualizar</button>
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