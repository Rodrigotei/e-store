<script setup>
    import { inject } from "vue";
    import { RouterLink } from "vue-router";
	const apiUrl = inject('apiUrl');
</script>

<template>
    <div>
        <div class="logo">
            <RouterLink to="/"><img :src="`${apiUrl}images/img/logo.png`"/></RouterLink>
        </div>
    </div>
</template>

<style>
    .logo{
        background-color: #3f2816;
        height: 10vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .logo img{
        width: 180px;
    }
</style>