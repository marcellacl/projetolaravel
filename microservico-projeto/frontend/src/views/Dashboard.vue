<template>
  <div>
    <h1 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h1>

    <div class="row g-3">
      <div class="col-md-4">
        <div class="card text-white bg-primary">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-people-fill"></i> Total de Usuários</h5>
            <p class="card-text fs-3">{{ stats.total_users }}</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-white bg-success">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-shield-lock"></i> Admins</h5>
            <p class="card-text fs-3">{{ stats.total_admins }}</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-white bg-info">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-person"></i> Usuários Comuns</h5>
            <p class="card-text fs-3">{{ stats.total_common }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useToast } from 'vue-toastification'

const stats = ref({ total_users: 0, total_admins: 0, total_common: 0 })
const toast = useToast()

const fetchStats = async () => {
  try {
    const res = await api.get('/dashboard')
    stats.value = res.data
  } catch {
    toast.error('Erro ao carregar estatísticas!')
  }
}

onMounted(fetchStats)
</script>