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
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/products/:categoryId',
      name: 'productsCategory',
      component: () => import('../views/ProductsView.vue')
    },
    {
      path: '/productSingle/:productId',
      name: 'productSingle',
      component: () => import('../views/ProductSingleView.vue')
    },
    {
      path: '/cart',
      name: 'Cart',
      component: () => import('../views/CartView.vue')
    }
  ]
})

export default router
