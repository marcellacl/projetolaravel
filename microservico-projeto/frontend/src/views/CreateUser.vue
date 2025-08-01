<template>
  <div class="p-6">
    <h1 class="text-xl mb-4">Novo Usuário</h1>

    <form @submit.prevent="createUser" class="space-y-4">
      <div>
        <label class="block mb-1">Nome</label>
        <input v-model="name" type="text" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block mb-1">Email</label>
        <input v-model="email" type="email" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block mb-1">Senha</label>
        <input v-model="password" type="password" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block mb-1">Tipo de Usuário</label>
        <select v-model="role_id" class="border p-2 w-full" required>
          <option disabled value="">Selecione uma role</option>
          <option v-for="role in roles" :key="role.id" :value="role.id">
            {{ role.name }}
          </option>
        </select>
      </div>

      <button type="submit" class="bg-green-500 text-white px-4 py-2">Salvar</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'
import { useToast } from 'vue-toastification'

const name = ref('')
const email = ref('')
const password = ref('')
const role_id = ref('')
const roles = ref([])
const router = useRouter()
const toast = useToast()

const fetchRoles = async () => {
  try {
    const res = await api.get('/roles') // 🔹 Crie uma rota no backend para listar roles
    roles.value = res.data
  } catch {
    toast.error('Erro ao carregar roles')
  }
}

const createUser = async () => {
  try {
    await api.post('/users', { name: name.value, email: email.value, password: password.value, role_id: role_id.value })
    toast.success('Usuário criado com sucesso!')
    router.push('/users')
  } catch {
    toast.error('Erro ao criar usuário')
  }
}

onMounted(fetchRoles)
</script>
