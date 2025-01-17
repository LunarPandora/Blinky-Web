import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'

import { useSessionStore } from '@/stores/session';

import DashboardView from '../views/Dashboard/Admin/DashboardView.vue'

import Admin_TableJurusanPage from '../pages/Admin/TableJurusan.vue'
import Admin_UsersPage from '../pages/Admin/Users.vue'
import Admin_TablePelajar from '../pages/Admin/TablePelajar.vue'
import Admin_TablePengajar from '../pages/Admin/TablePengajar.vue'
import Admin_TableKelas from '../pages/Admin/TableKelas.vue'
import Admin_TableMataStudi from '../pages/Admin/TableMataStudi.vue'
import Admin_TableJadwal from '../pages/Admin/TableJadwal.vue'

import Pengajar_ProfilPage from '../pages/Pengajar/ProfilPengajar.vue'
import Pengajar_TableMataStudiPage from '../pages/Pengajar/TableMataStudi.vue'
import Pengajar_TableTanggalPage from '../pages/Pengajar/TableTanggal.vue'
import Pengajar_TablePresensiPage from '../pages/Pengajar/TablePresensi.vue'

import Pelajar_ProfilPage from '../pages/Pelajar/ProfilPelajar.vue'
import Pelajar_TableMataStudiPage from '../pages/Pelajar/TableMataStudi.vue'
import Pelajar_TablePresensiPage from '../pages/Pelajar/TablePresensi.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardView,
      children: [
        {
          path: '/dashboard/admin',
          name: 'dashboard_admin',
          redirect: {
            path: '/dashboard/admin/pelajar'
          },
          children: [
            {
              path: '/dashboard/admin/jurusan',
              component: Admin_TableJurusanPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/admin/users',
              component: Admin_UsersPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/admin/pelajar',
              component: Admin_TablePelajar,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/admin/pengajar',
              component: Admin_TablePengajar,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/admin/kelas',
              component: Admin_TableKelas,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/admin/jadwal',
              component: Admin_TableJadwal,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/admin/mata_studi',
              component: Admin_TableMataStudi,
              // alias: '/dashboard/'
            }
          ]
        },
        {
          path: '/dashboard/pengajar',
          name: 'dashboard_pengajar',
          redirect: {
            path: '/dashboard/pengajar/mata_studi'
          },
          children: [
            {
              path: '/dashboard/pengajar/profil',
              component: Pengajar_ProfilPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/pengajar/mata_studi',
              component: Pengajar_TableMataStudiPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/pengajar/mata_studi/presensi/:id_jadwal',
              component: Pengajar_TableTanggalPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/pengajar/mata_studi/presensi/:id_jadwal/:id_pertemuan/:pertemuan',
              component: Pengajar_TablePresensiPage,
              // alias: '/dashboard/'
            }
          ]
        },
        {
          path: '/dashboard/pelajar',
          name: 'dashboard_pelajar',
          redirect: {
            path: '/dashboard/pelajar/mata_studi'
          },
          children: [
            {
              path: '/dashboard/pelajar/profil',
              component: Pelajar_ProfilPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/pelajar/mata_studi',
              component: Pelajar_TableMataStudiPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/pelajar/presensi/:id_jadwal',
              component: Pelajar_TablePresensiPage,
              // alias: '/dashboard/'
            },
            // {
            //   path: '/dashboard/pengajar/pelajar',
            //   component: Pengajar_TablePelajarPage,
            // }
          ]
        }
      ]
    },
  ]
})

router.beforeEach((to) => {
  const sessionStore = useSessionStore()
  
  if(to.path.includes('dashboard')){
    sessionStore.refreshSession()

    if (sessionStore.isAuthenticated == false){
      return '/'
    } 
  }
})

export default router
