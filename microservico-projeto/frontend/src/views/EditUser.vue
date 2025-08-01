<template>
  <div class="p-6">
    <h1 class="text-xl mb-4">Editar Usuário</h1>

    <form @submit.prevent="updateUser" class="space-y-4">
      <div>
        <label class="block mb-1">Nome</label>
        <input v-model="name" type="text" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block mb-1">Email</label>
        <input v-model="email" type="email" class="border p-2 w-full" required />
      </div>

      <div>
        <label class="block mb-1">Senha (deixe em branco para não alterar)</label>
        <input v-model="password" type="password" class="border p-2 w-full" />
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

      <button type="submit" class="bg-blue-500 text-white px-4 py-2">Atualizar</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../services/api'
import { useToast } from 'vue-toastification'

const route = useRoute()
const router = useRouter()
const toast = useToast()

const name = ref('')
const email = ref('')
const password = ref('')
const role_id = ref('')
const roles = ref([])

const fetchRoles = async () => {
  try {
    const res = await api.get('/roles')
    roles.value = res.data
  } catch {
    toast.error('Erro ao carregar roles')
  }
}

const fetchUser = async () => {
  try {
    const res = await api.get(`/users/${route.params.id}`)
    name.value = res.data.name
    email.value = res.data.email
    role_id.value = res.data.role_id
  } catch {
    toast.error('Erro ao carregar usuário')
  }
}

const updateUser = async () => {
  try {
    await api.put(`/users/${route.params.id}`, {
      name: name.value,
      email: email.value,
      password: password.value || undefined,
      role_id: role_id.value,
    })
    toast.success('Usuário atualizado com sucesso!')
    router.push('/users')
  } catch {
    toast.error('Erro ao atualizar usuário')
  }
}

onMounted(() => {
  fetchRoles()
  fetchUser()
})
</script>
