<script setup>
    import { reactive, ref, onMounted } from 'vue';
    import { useGlobal } from '@/global';
    import FinishOrder from '@/components/finish-order.vue';
    import LastProducts from '@/components/last-products.vue';

    const GlobalVariables = useGlobal();

    const userCode = ref(localStorage.getItem('idUser'));
    const qtdCart = reactive({});
    const productsCart = reactive({ 'prod': [] });
    const totalCarrinho = ref(0);
    const showOptions = reactive({});

    const emit = defineEmits(['upcart']);

    async function obterProdutosCarrinho(idUser) {
        // Limpar as estruturas de dados
        productsCart.prod = [];
        for (const key in qtdCart) {
            if (qtdCart.hasOwnProperty(key)) {
                delete qtdCart[key];
            }
        }
        for (const key in showOptions) {
            if (showOptions.hasOwnProperty(key)) {
                delete showOptions[key];
            }
        }
        let response = await fetch(`${GlobalVariables.apiUrl}carrinho/${idUser}`);
        let data = await response.json();

        const promises = data.map(element => {
            qtdCart[element.id_produto] = element.qtd;
            showOptions[element.id_produto] = false;
            return obterProduto(element.id_produto);
        });

        await Promise.all(promises);
        calcularCarrinho();
    }

    async function obterProduto(idProduto) {
        let response = await fetch(`${GlobalVariables.apiUrl}produtos/${idProduto}`);
        let data = await response.json();
        productsCart.prod.push(data[0]);
    }

    async function decreaseQtd(idProduto) {
        if (qtdCart[idProduto] > 1) {
            let response = await fetch(`${GlobalVariables.apiUrl}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 'decreaseQtdProduct': true, 'idProduto': idProduto, 'idUser': userCode.value })
            });
            let data = await response.json();
            if (data) {
                qtdCart[idProduto] -= 1;
                calcularCarrinho();
            } else {
                console.log('error');
            }
        }
    }

    async function increaseQtd(idProduto) {
        let response = await fetch(`${GlobalVariables.apiUrl}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 'increaseQtdProduct': true, 'idProduto': idProduto, 'idUser': userCode.value })
        });
        let data = await response.json();
        if (data) {
            qtdCart[idProduto] += 1;
            calcularCarrinho();
        } else {
            console.log('error');
        }
    }
    async function deleteProduct(id){
        let response = await fetch(`${GlobalVariables.apiUrl}`,{
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({'deleteProduct':true, 'idProduto':id, 'idUser': userCode.value})
        })
        let data = await response.json();
        if(data){
            alert('Deletado com sucesso!');
            obterProdutosCarrinho(userCode.value);
            emit('upcart');
        }
    }
    function calcularCarrinho() {
        totalCarrinho.value = 0;
        productsCart.prod.forEach(product => {
            const preco = parseFloat(product.preco.replace(',', '.'));
            const qtd = qtdCart[product.id];
            totalCarrinho.value += preco * qtd;
        });
        totalCarrinho.value = totalCarrinho.value.toFixed(2).replace('.', ',');
    }

    function toggleOptions(idProduto) {
        showOptions[idProduto] = !showOptions[idProduto];
    }
    function finish(data){
        const number = GlobalVariables.numberPhone;
        const nameClient = data.nameClient.trim()
        if(productsCart.prod.length > 1){
            let produtos = '*Produtos*: ';
            productsCart.prod.forEach(product=>{
                produtos += '%0A'+product.nome.trim()+'%0APreço: *R$ '+product.preco+'* %0AQuantidade: *'+qtdCart[product.id]+' und*%0A---------------------'
            })
            let mensagemTotal = `Olá RT.CODE%0AEste é o meu pedido:%0A${produtos}%0ANome Cliente: *${nameClient}*%0AEndereço: ${data.address}, ${data.number}, ${data.district}%0AObservação: ${data.obs}%0ATotal: *R$ ${totalCarrinho.value}*`

            window.open(`https://wa.me/${number}?text=${mensagemTotal   }`);

        }else{
            let produto = '*Produto*: ';
            productsCart.prod.forEach(product=>{
                produto += '%0A'+product.nome.trim()+'%0APreço: *R$ '+product.preco+'* %0AQuantidade: *'+qtdCart[product.id]+' und*%0A---------------------'
            })
            let mensagemTotal = `Olá RT.CODE%0AEste é o meu pedido:%0A${produto}%0ANome Cliente: *${nameClient}*%0AEndereço: ${data.address}, ${data.number}, ${data.district}%0AObservação: ${data.obs}%0ATotal: *R$ ${totalCarrinho.value}*`
            window.open(`https://wa.me/${number}?text=${mensagemTotal}`);
        }
    }
    onMounted(() => {
        obterProdutosCarrinho(userCode.value);
    });
</script>

<template>
    <div>
        <h1>Seu Carrinho</h1>
        <div class="container-cart" v-if="productsCart.prod.length > 0">
            <div class="product-cart-single" v-for="product in productsCart.prod" v-bind:key="product.id">
                <header>
                    <div class="img-product"><img :src="`${GlobalVariables.apiUrl}images/img/produtos/${product.img}`"></div>
                    <div class="name-product">{{ product.nome }}</div>
                </header>
                <div class="inf-product">
                    <div class="price-product">R$ <b>{{ product.preco }}</b></div>
                </div>
                <div class="qtd-product">
                    <div class="decrease" v-on:click="decreaseQtd(product.id)"><i class="fa-sharp fa-solid fa-circle-minus"></i></div>
                    <p>{{ qtdCart[product.id] }}</p>
                    <div class="increase" v-on:click="increaseQtd(product.id)"><i class="fa-sharp fa-solid fa-circle-plus"></i></div>
                </div>
                
                <div class="btn-options" v-on:click="toggleOptions(product.id)">
                    <p v-if="showOptions[product.id]"><i class="fa-solid fa-xmark"></i></p>
                    <p v-else><i class="fa-solid fa-ellipsis-vertical"></i></p>
                </div>
                <div class="options-product" :style="showOptions[product.id] ? { display: 'flex' } : { display: 'none' }"
                     v-on:click="deleteProduct(product.id)">
                    <p>Deletar</p>
                    <p><i class="fa-solid fa-trash-can"></i></p>
                </div>

            </div>
            <div class="total">
                <h2 class="total-cart">Total: <b>R$ {{ totalCarrinho }}</b></h2>
            </div>
        </div>
        <div class="empty-products" v-else>
            <h2>Nenhum produto foi adicionado ao carrinho!</h2>
            <a href="/">Retornar</a>
        </div>
        <FinishOrder v-on:finishOrder="finish" v-if="productsCart.prod.length > 0"/>
        <LastProducts />
    </div>
</template>

<style scoped>
    h1{
        text-align: center;
        font-size: 25px;
        margin-top: 10px;
    }
    .container-cart{
        width: 100%;
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 10px;
        padding: 10px;
    }
    .product-cart-single{
        width: 100%;
        max-width: 500px;
        border: 2px solid black;
        position: relative;
    }
    .product-cart-single header{
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid black;
    }
    .product-cart-single .name-product{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .product-cart-single .img-product{
        width: 100px;
        padding: 5px;
        border-right: 2px solid black;
    }
    .product-cart-single img{
        width: 100%;
    }
    .product-cart-single .price-product{
        text-align: center;
        padding: 10px 0;
        border-bottom: 1px solid black;
    }
    .product-cart-single .qtd-product{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        cursor: pointer;
        font-size: 18px;
    }
    .qtd-product p{
        cursor:default;
    }
    h2.total-cart{
        width: 220px;
        text-align: center;
        font-size: 20px;
        padding: 5px 0;
        margin-top: 10px;
        border: 2px solid #111;
    }
    .btn-options{
        border: 2px solid black;
        width: 30px;
        text-align: center;
        position: absolute;
        top: 0;
        right: 0;
        padding: 2px;
        cursor: pointer;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }   
    .btn-options:active{
        transform: scale(0.9);
    }
    .options-product{
        position: absolute;
        top: -20px;
        right: 30px;
        width: 80px;
        padding: 5px ;
        border: 2px solid black;
        background-color: #fff;
        display: none;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    .options-product:active{
        background-color: rgb(205, 22, 22);
        color: #fff;     
    }
    .empty-products{
        height: 270px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .empty-products a{
        display: block;
        text-decoration: none;
        background-color: #111;
        color: #fff;
        width: 220px;
        text-align: center;
        font-size: 20px;
        padding: 10px 0;
        border-radius: 30px;
        margin-top: 10px;
    }
</style>