<script setup>
    import { ref } from 'vue';

    const user = ref('');
    const password = ref('');

    async function acessarConta(){
        let response = await fetch(`http://localhost/e-store/e-store-api/`,{
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({'authenticate': true, 'user': user.value, 'pass': password.value})
        });
        let data = await response.json();
        if(data){
            const div = document.createElement('div');
            div.style.position = 'absolute'; div.style.top = '20%';
            div.style.left = '50%'; div.style.transform = 'translateX(-50%)';
            div.style.width = '200px'; div.style.padding = '10px 0';
            div.style.backgroundColor = 'rgb(54, 190, 54)'; div.style.color = '#fff';
            div.style.textAlign = 'center'; div.style.borderRadius = '10px';
            div.style.fontSize = '16px'; div.innerText = 'Entrando...';
            document.body.appendChild(div);
            
            //CRIANDO O COOKIE DE LOGIN
            let data = new Date();
            document.cookie = 'logado=true; exepire='+data.setTime(data.getTime() + (60 * 1000 * 60));
            setTimeout(()=>{
                div.remove();
                window.location.href = '/';
            },1000);
        }else{

        }
    }
</script>

<template>
    <div> 
        <div class="container-login">
            <div class="form">
                <div class="img"><img src="/img/logo.png" alt=""></div>
                <div><input type="text" placeholder="usuário" v-model="user"></div>
                <div><input type="password" placeholder="senha" v-model="password"></div>
                <div><button v-on:click="acessarConta()">Entrar</button></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .container-login{
        width: 100vw;
        height: 100vh;
        background-image: linear-gradient(#d49463, #341c0a);
    }
    .form{
        width: 100%;
        max-width: 400px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 0px 10px;
        background-color: #593a23;
        border: 5px solid gray;
        border-color: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        -khtml-border-radius: 10px;
    }
    .form div{
        width: 100%;
        margin: 10px 0;
    }
    input{
        width: 100%;
        padding: 8px 5px;
        font-size: 16px;
        outline: none;
    }
    button{
        width: 120px;
        padding: 10px 0;
        display: block;
        margin: 10px auto;
        background-color: #341c0a;
        color: white;
        border: none;
        border-radius: 5px ;
        font-size: 16px;
    }
    button:active{
        box-shadow: 0px 0px 10px white;
    }
    div.img{
        text-align: center;
        border: 2px;
        border-radius: 5px;
    }
    img{
        width: 200px;
    }
</style>