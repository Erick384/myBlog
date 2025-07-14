<template>
  <div id="app">
    <nav v-if="isAuthenticated" class="bg-blue-600 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold">Task Management System</h1>
        <div class="flex space-x-4">
          <router-link to="/" class="hover:text-blue-200">Dashboard</router-link>
          <router-link to="/tasks" class="hover:text-blue-200">Tasks</router-link>
          <router-link v-if="user.role === 'admin'" to="/users" class="hover:text-blue-200">Users</router-link>
          <button @click="logout" class="hover:text-blue-200">Logout</button>
        </div>
      </div>
    </nav>
    
    <main class="container mx-auto p-4">
      <router-view />
    </main>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      user: {}
    }
  },
  computed: {
    isAuthenticated() {
      return !!localStorage.getItem('token')
    }
  },
  mounted() {
    if (this.isAuthenticated) {
      this.user = JSON.parse(localStorage.getItem('user') || '{}')
    }
  },
  methods: {
    async logout() {
      try {
        await this.$http.post('/logout')
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        this.$router.push('/login')
      }
    }
  }
}
</script>

<style>
body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
}

#app {
  min-height: 100vh;
  background-color: #f5f5f5;
}
</style>
