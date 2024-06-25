<script setup>
</script>


<template>

    <footer>
        <div>
            <div>
                <a href="mailto:rodrigoteixeira.oli0@gmail.com">E-mail: rodrigoteixeira.oli0@gmail.com</a>
                <a href="tel:+5579996820727">Telefone: (79) 99682-0727</a>
            </div>
            <p>Todos os direitos reservados &copy</p>
        </div>
    </footer>

</template>


<style scoped>

    footer{
        width: 100%;
        min-height: 10vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #111111;
        color: #fefed5;
        flex-direction: column;
        padding: 20px 0;
        gap: 10px;
    }
    footer div{
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }
    footer a{
        color: #fff;
        text-decoration: none;
    }
</style>