// 📄 src/store.js
import { defineStore } from 'pinia'
import api from './services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null
  }),
  getters: {
    isAuthenticated: (state) => !!state.token
  },
  actions: {
    async login(email, password) {
      const res = await api.post('/login', { email, password })
      this.token = res.data.token
      this.user = res.data.user
      localStorage.setItem('token', this.token)
      api.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    },
    logout() {
      this.user = null
      this.token = null
      localStorage.removeItem('token')
      delete api.defaults.headers.common['Authorization']
    }
  }
})
