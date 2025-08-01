<template>
  <div class="d-flex">
    <!-- ✅ Sidebar fixa -->
    <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
      <h3 class="mb-4"><i class="bi bi-speedometer2"></i> Painel Admin</h3>
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <router-link to="/dashboard" class="nav-link text-white" active-class="active fw-bold">
            <i class="bi bi-bar-chart"></i> Dashboard
          </router-link>
        </li>
        <li class="nav-item mb-2">
          <router-link to="/users" class="nav-link text-white" active-class="active fw-bold">
            <i class="bi bi-people"></i> Usuários
          </router-link>
        </li>
      </ul>
      <button class="btn btn-danger mt-3 w-100" @click="logout"><i class="bi bi-box-arrow-right"></i> Sair</button>
    </div>

    <div class="flex-grow-1 p-4">
      <router-view />
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import api from '../services/api'

const router = useRouter()

const logout = async () => {
  try {
    await api.post('/logout')
    localStorage.removeItem('token')
    router.push('/')
  } catch {
    localStorage.removeItem('token')
    router.push('/')
  }
}
</script>