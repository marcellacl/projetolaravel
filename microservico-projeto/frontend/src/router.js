import { createRouter, createWebHistory } from 'vue-router'
import Login from './views/login.vue'
import Users from './views/Users.vue'
import CreateUser from './views/CreateUser.vue'
import EditUser from './views/EditUser.vue'
import Dashboard from './views/Dashboard.vue'
import Layout from './layouts/Layout.vue'
import { useAuthStore } from './store'

const routes = [
  { path: '/', component: Login },

  {
    path: '/',
    component: Layout,
    meta: { requiresAuth: true },
    children: [
      { path: '/dashboard', component: Dashboard },
      { path: '/users', component: Users },
      { path: '/users/create', component: CreateUser, meta: { adminOnly: true } },
      { path: '/users/:id/edit', component: EditUser },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const auth = useAuthStore()

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return next('/')
  }

  if (to.meta.adminOnly && auth.user?.id !== 1) {
    return next('/users')
  }

  next()
})

export default router