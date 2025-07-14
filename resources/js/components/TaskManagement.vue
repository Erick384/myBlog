<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Task Management</h1>
      <button
        v-if="user.role === 'admin'"
        @click="showCreateModal = true"
        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
      >
        Create Task
      </button>
    </div>
    
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <div v-if="loading" class="text-center py-4">Loading...</div>
        
        <div v-else-if="tasks.length === 0" class="text-center py-4 text-gray-500">
          No tasks found
        </div>
        
        <div v-else class="space-y-4">
          <div
            v-for="task in tasks"
            :key="task.id"
            class="border rounded-lg p-4"
          >
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <h3 class="font-semibold text-lg">{{ task.title }}</h3>
                <p class="text-gray-600 mt-1">{{ task.description }}</p>
                <div class="mt-2 text-sm text-gray-500">
                  <p>Assigned to: {{ task.assigned_user?.name }}</p>
                  <p>Created by: {{ task.creator?.name }}</p>
                  <p>Deadline: {{ formatDate(task.deadline) }}</p>
                </div>
              </div>
              
              <div class="flex items-center space-x-2">
                <select
                  v-model="task.status"
                  @change="updateTaskStatus(task)"
                  class="px-2 py-1 border border-gray-300 rounded text-sm"
                >
                  <option value="pending">Pending</option>
                  <option value="in_progress">In Progress</option>
                  <option value="completed">Completed</option>
                </select>
                
                <button
                  v-if="user.role === 'admin'"
                  @click="editTask(task)"
                  class="text-blue-600 hover:text-blue-800 text-sm"
                >
                  Edit
                </button>
                
                <button
                  v-if="user.role === 'admin'"
                  @click="deleteTask(task.id)"
                  class="text-red-600 hover:text-red-800 text-sm"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Create/Edit Task Modal -->
    <div
      v-if="showCreateModal || showEditModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white p-6 rounded-lg w-96 max-w-full">
        <h2 class="text-xl font-bold mb-4">
          {{ showEditModal ? 'Edit Task' : 'Create Task' }}
        </h2>
        
        <form @submit.prevent="showEditModal ? updateTask() : createTask()">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input
              v-model="taskForm.title"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
            />
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea
              v-model="taskForm.description"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
            ></textarea>
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Assign to</label>
            <select
              v-model="taskForm.assigned_to"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
            >
              <option value="">Select User</option>
              <option
                v-for="user in users"
                :key="user.id"
                :value="user.id"
              >
                {{ user.name }}
              </option>
            </select>
          </div>
          
          <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deadline</label>
            <input
              v-model="taskForm.deadline"
              type="datetime-local"
              required
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
  name: 'TaskManagement',
  data() {
    return {
      tasks: [],
      users: [],
      loading: true,
      showCreateModal: false,
      showEditModal: false,
      taskForm: {
        title: '',
        description: '',
        assigned_to: '',
        deadline: ''
      },
      editingTask: null,
      user: JSON.parse(localStorage.getItem('user') || '{}')
    }
  },
  async mounted() {
    await this.fetchTasks()
    if (this.user.role === 'admin') {
      await this.fetchUsers()
    }
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await this.$http.get('/tasks')
        this.tasks = response.data
      } catch (error) {
        console.error('Error fetching tasks:', error)
      } finally {
        this.loading = false
      }
    },
    
    async fetchUsers() {
      try {
        const response = await this.$http.get('/users')
        this.users = response.data
      } catch (error) {
        console.error('Error fetching users:', error)
      }
    },
    
    async createTask() {
      try {
        await this.$http.post('/tasks', this.taskForm)
        await this.fetchTasks()
        this.closeModal()
      } catch (error) {
        console.error('Error creating task:', error)
      }
    },
    
    async updateTask() {
      try {
        await this.$http.put(`/tasks/${this.editingTask.id}`, this.taskForm)
        await this.fetchTasks()
        this.closeModal()
      } catch (error) {
        console.error('Error updating task:', error)
      }
    },
    
    async updateTaskStatus(task) {
      try {
        await this.$http.patch(`/tasks/${task.id}/status`, {
          status: task.status
        })
      } catch (error) {
        console.error('Error updating task status:', error)
        await this.fetchTasks() // Refresh to revert changes
      }
    },
    
    async deleteTask(taskId) {
      if (confirm('Are you sure you want to delete this task?')) {
        try {
          await this.$http.delete(`/tasks/${taskId}`)
          await this.fetchTasks()
        } catch (error) {
          console.error('Error deleting task:', error)
        }
      }
    },
    
    editTask(task) {
      this.editingTask = task
      this.taskForm = {
        title: task.title,
        description: task.description,
        assigned_to: task.assigned_to,
        deadline: task.deadline.slice(0, 16) // Format for datetime-local input
      }
      this.showEditModal = true
    },
    
    closeModal() {
      this.showCreateModal = false
      this.showEditModal = false
      this.editingTask = null
      this.taskForm = {
        title: '',
        description: '',
        assigned_to: '',
        deadline: ''
      }
    },
    
    formatDate(date) {
      return new Date(date).toLocaleString()
    }
  }
}
</script>
