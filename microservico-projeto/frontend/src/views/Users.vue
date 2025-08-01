<template>
  <div>
    <h1 class="mb-4"><i class="bi bi-people"></i> Usuários</h1>

    <div class="d-flex mb-3 gap-2">
      <input v-model="search" placeholder="Buscar usuário..." class="form-control w-25" />
      <button @click="fetchUsers" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
      <button @click="openCreateModal" class="btn btn-success"><i class="bi bi-plus-circle"></i> Novo Usuário</button>
    </div>

    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>Tipo</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="u in users" :key="u.id">
          <td>{{ u.name }}</td>
          <td>{{ u.email }}</td>
          <td>{{ u.role?.name }}</td>
          <td>
            <button @click="openEditModal(u)" class="btn btn-warning btn-sm">
              <i class="bi bi-pencil"></i>
            </button>
            <button @click="confirmDelete(u.id)" class="btn btn-danger btn-sm ms-2">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" tabindex="-1" ref="modalRef">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              <i class="bi" :class="isEditing ? 'bi-pencil' : 'bi-plus-circle'"></i>
              {{ isEditing ? ' Editar Usuário' : ' Novo Usuário' }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label>Nome</label>
              <input v-model="form.name" class="form-control" />
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input v-model="form.email" class="form-control" />
            </div>
            <div class="mb-3">
              <label>Senha</label>
              <input v-model="form.password" type="password" class="form-control" />
            </div>
            <div class="mb-3">
              <label>Tipo</label>
              <select v-model="form.role_id" class="form-select">
                <option v-for="r in roles" :key="r.id" :value="r.id">{{ r.name }}</option>
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
            <button @click="saveUser" class="btn btn-primary"><i class="bi bi-check-circle"></i> Salvar</button>
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
import { Modal } from 'bootstrap'

const users = ref([])
const roles = ref([])
const search = ref('')
const toast = useToast()

const modalRef = ref(null)
let modalInstance

const showModal = () => modalInstance.show()
const hideModal = () => modalInstance.hide()

const isEditing = ref(false)
const selectedUserId = ref(null)

const form = ref({ name: '', email: '', password: '', role_id: '' })

const fetchUsers = async () => {
  try {
    const res = await api.get('/users', { params: { search: search.value } })
    users.value = res.data
  } catch {
    toast.error('Erro ao carregar usuários')
  }
}

const fetchRoles = async () => {
  try {
    const res = await api.get('/roles')
    roles.value = res.data
  } catch {
    toast.error('Erro ao carregar roles')
  }
}

const openCreateModal = () => {
  isEditing.value = false
  form.value = { name: '', email: '', password: '', role_id: roles.value[0]?.id || '' }
  showModal()
}

const openEditModal = (user) => {
  isEditing.value = true
  selectedUserId.value = user.id
  form.value = { name: user.name, email: user.email, password: '', role_id: user.role_id }
  showModal()
}

const saveUser = async () => {
  try {
    if (isEditing.value) {
      await api.put(`/users/${selectedUserId.value}`, form.value)
      toast.success('Usuário atualizado com sucesso!')
    } else {
      await api.post('/users', form.value)
      toast.success('Usuário criado com sucesso!')
    }
    fetchUsers()
    hideModal()
  } catch {
    toast.error('Erro ao salvar usuário')
  }
}

const confirmDelete = async (id) => {
  if (confirm('Deseja excluir este usuário?')) {
    try {
      await api.delete(`/users/${id}`)
      toast.success('Usuário excluído com sucesso!')
      fetchUsers()
    } catch {
      toast.error('Erro ao excluir usuário')
    }
  }
}

onMounted(() => {
  fetchUsers()
  fetchRoles()
  modalInstance = new Modal(modalRef.value)
})
</script>