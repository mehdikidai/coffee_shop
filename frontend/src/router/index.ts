import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import { useUserStore } from '@/stores/user'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {
        requiredAuth: true,
      },
    },
    {
      path: '/cart',
      name: 'cart',
      component: () => import('../views/CartView.vue'),
      meta: {
        requiredAuth: true,
      },
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/LoginView.vue'),
      meta:{
        requiredGuest:true
      }
    },
  ],
})



router.beforeEach((to, from, next) => {

  const userStore = useUserStore()
  const isLoggedIn = userStore.isAuthenticated


  if (to.meta.requiredAuth && !isLoggedIn) {
    next('/login')

  } else if (to.meta.requiredGuest && isLoggedIn) {
    next('/')

  } else {
    next()
  }
})


export default router
