<template>
  <div>
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700">Total Tasks</h3>
        <p class="text-3xl font-bold text-blue-600">{{ stats.total }}</p>
      </div>
      
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700">Pending Tasks</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ stats.pending }}</p>
      </div>
      
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700">Completed Tasks</h3>
        <p class="text-3xl font-bold text-green-600">{{ stats.completed }}</p>
      </div>
    </div>
    
    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold">Recent Tasks</h2>
      </div>
      
      <div class="p-6">
        <div v-if="loading" class="text-center py-4">Loading...</div>
        
        <div v-else-if="tasks.length === 0" class="text-center py-4 text-gray-500">
          No tasks found
        </div>
        
        <div v-else class="space-y-4">
          <div
            v-for="task in tasks.slice(0, 5)"
            :key="task.id"
            class="border rounded-lg p-4"
          >
            <div class="flex justify-between items-start">
              <div>
                <h3 class="font-semibold">{{ task.title }}</h3>
                <p class="text-gray-600 text-sm">{{ task.description }}</p>
                <p class="text-sm text-gray-500 mt-1">
                  Deadline: {{ formatDate(task.deadline) }}
                </p>
              </div>
              
              <span
                :class="getStatusClass(task.status)"
                class="px-2 py-1 rounded-full text-xs font-medium"
              >
                {{ getStatusLabel(task.status) }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Dashboard',
  data() {
    return {
      tasks: [],
      loading: true,
      stats: {
        total: 0,
        pending: 0,
        completed: 0
      }
    }
  },
  async mounted() {
    await this.fetchTasks()
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await this.$http.get('/tasks')
        this.tasks = response.data
        this.calculateStats()
      } catch (error) {
        console.error('Error fetching tasks:', error)
      } finally {
        this.loading = false
      }
    },
    
    calculateStats() {
      this.stats.total = this.tasks.length
      this.stats.pending = this.tasks.filter(task => task.status === 'pending').length
      this.stats.completed = this.tasks.filter(task => task.status === 'completed').length
    },
    
    formatDate(date) {
      return new Date(date).toLocaleDateString()
    },
    
    getStatusClass(status) {
      const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        in_progress: 'bg-blue-100 text-blue-800',
        completed: 'bg-green-100 text-green-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },
    
    getStatusLabel(status) {
      const labels = {
        pending: 'Pending',
        in_progress: 'In Progress',
        completed: 'Completed'
      }
      return labels[status] || status
    }
  }
}
</script>
