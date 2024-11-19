import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'

import { useSessionStore } from '@/stores/session';

import DashboardView from '../views/Dashboard/Admin/DashboardView.vue'

import Dosen_ProfilPage from '../pages/Dosen/ProfilDosen.vue'
import Dosen_TableMatkulPage from '../pages/Dosen/TableMatkul.vue'
import Dosen_TableTanggalPage from '../pages/Dosen/TableTanggal.vue'
import Dosen_TableAbsensiPage from '../pages/Dosen/TableAbsensi.vue'

import Mahasiswa_ProfilPage from '../pages/Mahasiswa/ProfilMahasiswa.vue'
import Mahasiswa_TableMatkulPage from '../pages/Mahasiswa/TableMatkul.vue'

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
              path: '/dashboard/dosen/matkul/absensi/:id_jadwal/:id_tanggal',
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
