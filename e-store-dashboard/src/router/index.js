import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/LoginView.vue')
    }
  ]
});



router.beforeEach((to, from) => {
  let autenticated = getCookie('logado');
  if(!autenticated && to.name != 'login'){
    return { name: 'login' };
  }
  if(autenticated && to.name == 'login'){
    return { name: 'home'};
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
          return cookie.substring(cookieName.length + 1);
      }
  }
  return false;
}

export default router