import { createApp } from "vue"
import { createRouter, createWebHistory } from "vue-router"
import axios from "axios"
import App from "./App.vue"
import Login from "./components/Login.vue"
import Dashboard from "./components/Dashboard.vue"
import UserManagement from "./components/UserManagement.vue"
import TaskManagement from "./components/TaskManagement.vue"

// Configure axios
axios.defaults.baseURL = "/api"
axios.defaults.headers.common["Accept"] = "application/json"
axios.defaults.headers.common["Content-Type"] = "application/json"

// Add token to requests if available
const token = localStorage.getItem("token")
if (token) {
  axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}

// Request interceptor to add token
axios.interceptors.request.use((config) => {
  const token = localStorage.getItem("token")
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

// Response interceptor to handle auth errors
axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem("token")
      localStorage.removeItem("user")
      window.location.href = "/login"
    }
    return Promise.reject(error)
  },
)

const routes = [
  { path: "/login", component: Login, name: "login" },
  { path: "/", component: Dashboard, name: "dashboard", meta: { requiresAuth: true } },
  { path: "/users", component: UserManagement, name: "users", meta: { requiresAuth: true, requiresAdmin: true } },
  { path: "/tasks", component: TaskManagement, name: "tasks", meta: { requiresAuth: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Navigation guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("token")
  const user = JSON.parse(localStorage.getItem("user") || "{}")

  if (to.meta.requiresAuth && !token) {
    next("/login")
  } else if (to.meta.requiresAdmin && user.role !== "admin") {
    next("/")
  } else if (to.name === "login" && token) {
    next("/")
  } else {
    next()
  }
})

const app = createApp(App)
app.use(router)
app.config.globalProperties.$http = axios
app.mount("#app")
