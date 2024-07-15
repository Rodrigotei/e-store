import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/idClient.js'

const app = createApp(App)

//AQUI SE CRIA AS VARIÁVEIS GLOBAIS E SAO ACESSADAS COMO OBJETOS
const globalVariables = {
    apiUrl: 'http://localhost/e-store/e-store-api/',
    numberPhone: 'xxxxxxxxxxxx',
}

app.provide('globalVariables', globalVariables)


app.use(router)

app.mount('#app')