import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'main',
      component: () => import('../views/MainView.vue')
    },
    {
      path: '/login',
      name: 'login',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/LoginView.vue')
    }
  ]
})

router.beforeEach((to, from)=>{
  let autenticado = getCookie('logado');
  if(!autenticado && to.name !== 'login'){
    return {name : 'login'}
  }
  if(autenticado && to.name === 'login'){
    return {name : 'main'}
  }
})

function getCookie(cookieName) {
  let cookies = document.cookie; 
  let cookieArray = cookies.split(';');
  for (let i = 0; i < cookieArray.length; i++) {
      let cookie = cookieArray[i].trim();
      // Verifica se o cookie começa com o nome desejado
      if (cookie.startsWith(cookieName + '=')) {
          // Retorna o valor do cookie, removendo o nome e o sinal de igual
          return true;
      }
  }
  return false;
}

export default router