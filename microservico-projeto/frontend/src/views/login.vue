<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 400px;">
      <div class="text-center mb-3">
        <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
        <h3 class="mt-2">Login</h3>
      </div>

      <form @submit.prevent="login">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input v-model="email" id="email" type="email" class="form-control" placeholder="Digite seu email" required />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input v-model="password" id="password" type="password" class="form-control" placeholder="Digite sua senha" required />
        </div>

        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-box-arrow-in-right"></i> Entrar
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'
import { useToast } from 'vue-toastification'

const email = ref('')
const password = ref('')
const router = useRouter()
const toast = useToast()

const login = async () => {
  try {
    const res = await api.post('/login', {
      email: email.value,
      password: password.value,
    })

    localStorage.setItem('token', res.data.token)
    toast.success('Login realizado com sucesso!')
    router.push('/dashboard')
  } catch (error) {
    toast.error('Credenciais inválidas')
  }
}
</script>