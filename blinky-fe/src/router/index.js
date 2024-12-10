import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'

import { useSessionStore } from '@/stores/session';

import DashboardView from '../views/Dashboard/Admin/DashboardView.vue'

import Admin_TableMahasiswa from '../pages/Admin/TableMahasiswa.vue'
import Admin_TableDosen from '../pages/Admin/TableDosen.vue'
import Admin_TableKelas from '../pages/Admin/TableKelas.vue'
import Admin_TableMatkul from '../pages/Admin/TableMatkul.vue'

import Dosen_ProfilPage from '../pages/Dosen/ProfilDosen.vue'
import Dosen_TableMatkulPage from '../pages/Dosen/TableMatkul.vue'
import Dosen_TableTanggalPage from '../pages/Dosen/TableTanggal.vue'
import Dosen_TableAbsensiPage from '../pages/Dosen/TableAbsensi.vue'

import Mahasiswa_ProfilPage from '../pages/Mahasiswa/ProfilMahasiswa.vue'
import Mahasiswa_TableMatkulPage from '../pages/Mahasiswa/TableMatkul.vue'
import Mahasiswa_TableAbsensiPage from '../pages/Mahasiswa/TableAbsensi.vue'

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
            path: '/dashboard/admin/mahasiswa'
          },
          children: [
            {
              path: '/dashboard/admin/mahasiswa',
              component: Admin_TableMahasiswa,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/admin/dosen',
              component: Admin_TableDosen,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/admin/kelas',
              component: Admin_TableKelas,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/admin/matkul',
              component: Admin_TableMatkul,
              // alias: '/dashboard/'
            }
          ]
        },
        {
          path: '/dashboard/dosen',
          name: 'dashboard_dosen',
          redirect: {
            path: '/dashboard/dosen/matkul'
          },
          children: [
            {
              path: '/dashboard/dosen/profil',
              component: Dosen_ProfilPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/dosen/matkul',
              component: Dosen_TableMatkulPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/dosen/matkul/absensi/:id_jadwal',
              component: Dosen_TableTanggalPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/dosen/matkul/absensi/:id_jadwal/:id_pertemuan',
              component: Dosen_TableAbsensiPage,
              // alias: '/dashboard/'
            }
          ]
        },
        {
          path: '/dashboard/mahasiswa',
          name: 'dashboard_mahasiswa',
          redirect: {
            path: '/dashboard/mahasiswa/kelas'
          },
          children: [
            {
              path: '/dashboard/mahasiswa/profil',
              component: Mahasiswa_ProfilPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/mahasiswa/matkul',
              component: Mahasiswa_TableMatkulPage,
              // alias: '/dashboard/'
            },
            {
              path: '/dashboard/mahasiswa/absensi',
              component: Mahasiswa_TableAbsensiPage,
              // alias: '/dashboard/'
            },
            // {
            //   path: '/dashboard/dosen/mahasiswa',
            //   component: Dosen_TableMahasiswaPage,
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
