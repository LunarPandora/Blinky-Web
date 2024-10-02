import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'

import DashboardAdminView from '../views/Dashboard/Admin/DashboardAdminView.vue'

import Admin_TableMahasiswaPage from '../pages/Admin/Table/TableMahasiswa.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/dashboard/admin',
      name: 'dashboard_admin',
      component: DashboardAdminView,
      redirect: {
        path: '/dashboard/admin/mahasiswa'
      },
      children: [
        {
          path: '/dashboard/admin/mahasiswa',
          component: Admin_TableMahasiswaPage,
        }
      ]
    },
  ]
})

export default router
