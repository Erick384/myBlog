<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">User Management</h1>
      <button
        @click="showCreateModal = true"
        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
      >
        Add User
      </button>
    </div>
    
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <div v-if="loading" class="text-center py-4">Loading...</div>
        
        <div v-else-if="users.length === 0" class="text-center py-4 text-gray-500">
          No users found
        </div>
        
        <div v-else class="overflow-x-auto">
          <table class="w-full table-auto">
            <thead>
              <tr class="border-b">
                <th class="text-left py-2">Name</th>
                <th class="text-left py-2">Email</th>
                <th class="text-left py-2">Role</th>
                <th class="text-left py-2">Created</th>
                <th class="text-left py-2">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="user in users"
                :key="user.id"
                class="border-b hover:bg-gray-50"
              >
                <td class="py-3">{{ user.name }}</td>
                <td class="py-3">{{ user.email }}</td>
                <td class="py-3">
                  <span
                    :class="user.role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800'"
                    class="px-2 py-1 rounded-full text-xs font-medium"
                  >
                    {{ user.role }}
                  </span>
                </td>
                <td class="py-3">{{ formatDate(user.created_at) }}</td>
                <td class="py-3">
                  <div class="flex space-x-2">
                    <button
                      @click="editUser(user)"
                      class="text-blue-600 hover:text-blue-800 text-sm"
                    >
                      Edit
                    </button>
                    <button
                      @click="deleteUser(user.id)"
                      class="text-red-600 hover:text-red-800 text-sm"
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <!-- Create/Edit User Modal -->
    <div
      v-if="showCreateModal || showEditModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white p-6 rounded-lg w-96 max-w-full">
        <h2 class="text-xl font-bold mb-4">
          {{ showEditModal ? 'Edit User' : 'Add User' }}
        </h2>
        
        <form @submit.prevent="showEditModal ? updateUser() : createUser()">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input
              v-model="userForm.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
            />
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input
              v-model="userForm.email"
              type="email"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
            />
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
            <select
              v-model="userForm.role"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
            >
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          
          <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">
              Password {{ showEditModal ? '(leave blank to keep current)' : '' }}
            </label>
            <input
              v-model="userForm.password"
              type="password"
              :required="!showEditModal"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
            />
          </div>
          
          <div class="flex justify-end space-x-2">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
            >
              {{ showEditModal ? 'Update' : 'Create' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'UserManagement',
  data() {
    return {
      users: [],
      loading: true,
      showCreateModal: false,
      showEditModal: false,
      userForm: {
        name: '',
        email: '',
        role: 'user',
        password: ''
      },
      editingUser: null
    }
  },
  async mounted() {
    await this.fetchUsers()
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await this.$http.get('/users')
        this.users = response.data
      } catch (error) {
        console.error('Error fetching users:', error)
      } finally {
        this.loading = false
      }
    },
    
    async createUser() {
      try {
        await this.$http.post('/users', this.userForm)
        await this.fetchUsers()
        this.closeModal()
      } catch (error) {
        console.error('Error creating user:', error)
      }
    },
    
    async updateUser() {
      try {
        await this.$http.put(`/users/${this.editingUser.id}`, this.userForm)
        await this.fetchUsers()
        this.closeModal()
      } catch (error) {
        console.error('Error updating user:', error)
      }
    },
    
    async deleteUser(userId) {
      if (confirm('Are you sure you want to delete this user?')) {
        try {
          await this.$http.delete(`/users/${userId}`)
          await this.fetchUsers()
        } catch (error) {
          console.error('Error deleting user:', error)
        }
      }
    },
    
    editUser(user) {
      this.editingUser = user
      this.userForm = {
        name: user.name,
        email: user.email,
        role: user.role,
        password: ''
      }
      this.showEditModal = true
    },
    
    closeModal() {
      this.showCreateModal = false
      this.showEditModal = false
      this.editingUser = null
      this.userForm = {
        name: '',
        email: '',
        role: 'user',
        password: ''
      }
    },
    
    formatDate(date) {
      return new Date(date).toLocaleDateString()
    }
  }
}
</script>
