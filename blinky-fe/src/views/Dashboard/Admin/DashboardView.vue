<script setup>
  import { ref, onMounted, watch } from 'vue'
	import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router'

  import apiClient from '@/services/api'
  import { useSessionStore } from '@/stores/session';

  const sessionStore = useSessionStore()
  const route = useRoute()
  const router = useRouter()
  const userData = ref()

  const role = sessionStore.session.role
  const currentPage = route.path

  watch(currentPage, (x, y) => {
    console.log(x, y)
  })

  async function getUser(){
    await apiClient.get('users/', {
      params: {
        'id': sessionStore.session.id,
      }
    })
    .then(resp => {
      userData.value = resp.data
    })
  }

  async function logout(){
    let a = confirm('Apakah anda yakin ingin logout?')

    if(a){
      await apiClient.post('logout')
      .then(resp => {
        if(resp.data == 'LOGOUT_SUCCESS'){
          sessionStore.inauthenticate()
          router.push('/')
        }
        else{
          alert('Logout gagal!')
        }
      })
    }
  }

  getUser()
</script>

<template>
  <div class="flex w-full h-screen justify-center p-4 bg-cream gap-4 font-light">
    <div class="flex w-[15%] h-full flex-col gap-5 sticky top-0 left-0">
      <!-- <img src="@/assets/icon.png" class=""> -->
      <div class="self-center p-3">
        <h1 class="logo text-4xl text-darkbrown">Blinky.</h1>
      </div>

      <div class="flex items-center gap-3 bg-white p-3 rounded-lg">
        <img src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541" class="rounded-md w-1/6">
        <div class="flex flex-col justify-center">  
          <p class="font-medium text-xs">{{ userData.email }}</p>
          <p class="text-xs">{{ userData.roles.role_name }}</p>
        </div>
      </div>

      <div class="flex flex-col h-full items-start justify-between pt-3">
        <p class="font-medium text-sm text-darkbrown pb-2">Menu</p>

        <div name="navbar_admin" class="flex flex-col w-full h-full gap-2" v-if="sessionStore.session.role == 'Admin'">
          <RouterLink to='/dashboard/admin/mahasiswa' class="flex items-center gap-3 p-3 rounded-xl" :class="{'bg-white *:text-leafgreen': currentPage.includes('/dashboard/admin/mahasiswa')}">
            <fa icon="fas fa-user-graduate" fixed-width class="text-xl text-white"></fa>
            <p class="text-white">Mahasiswa</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/users' class="flex items-center gap-3 p-3 rounded-xl" :class="{'bg-white *:text-leafgreen': currentPage.includes('/dashboard/admin/users')}">
            <fa icon="fas fa-users" fixed-width class="text-xl text-white"></fa>
            <p class="text-white">User</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/prodi' class="flex items-center gap-3 p-3 rounded-xl" :class="{'bg-white *:text-leafgreen': currentPage.includes('/dashboard/admin/prodi')}">
            <fa icon="fas fa-school" fixed-width class="text-xl text-white"></fa>
            <p class="text-white">Prodi</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/jadwal' class="flex items-center gap-3 p-3 rounded-xl" :class="{'bg-white *:text-leafgreen': currentPage.includes('/dashboard/admin/jadwal')}">
            <fa icon="fas fa-calendar" fixed-width class="text-xl text-white"></fa>
            <p class="text-white">Jadwal</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/kelas' class="flex items-center gap-3 p-3 rounded-xl" :class="{'bg-white *:text-leafgreen': currentPage.includes('/dashboard/admin/kelas')}">
            <fa icon="fas fa-door-closed" fixed-width class="text-xl text-white"></fa>
            <p class="text-white">Kelas</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/dosen' class="flex items-center gap-3 p-3 rounded-xl" :class="{'bg-white *:text-leafgreen': currentPage.includes('/dashboard/admin/dosen')}">
            <fa icon="fas fa-graduation-cap" fixed-width class="text-xl text-white"></fa>
            <p class="text-white">Dosen</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/matkul' class="flex items-center gap-3 p-3 rounded-xl" :class="{'bg-white *:text-leafgreen': currentPage.includes('/dashboard/admin/matkul')}">
            <fa icon="fas fa-book" fixed-width class="text-xl text-white"></fa>
            <p class="text-white">Mata Kuliah</p>
          </RouterLink>
        </div>

        <div name="navbar_dosen" class="flex flex-col w-full h-full gap-1" v-if="sessionStore.session.role == 'Dosen'">
          <RouterLink to='/dashboard/dosen/matkul' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-school" fixed-width class="text-md"></fa>
            <p class="text-sm">Mata Kuliah</p>
          </RouterLink>

          <RouterLink to='/dashboard/dosen/profil' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-user" fixed-width class="text-md"></fa>
            <p class="text-sm">Profil Dosen</p>
          </RouterLink>
        </div>

        <div name="navbar_mhswa" class="flex flex-col w-full h-full gap-5" v-if="sessionStore.session.role == 'Mahasiswa'">
          <RouterLink to='/dashboard/mahasiswa/matkul' class="flex items-center gap-3 p-3 rounded-xl" :class="{'bg-leafgreen *:text-white': currentPage.includes('/dashboard/mahasiswa/matkul')}">
            <fa icon="fas fa-school" fixed-width class="text-xl text-white"></fa>
            <p class="text-white">Mata Kuliah</p>
          </RouterLink>
        </div>

        <div class="flex flex-col w-full gap-5">
          
          <div @click="logout()" class="flex items-center gap-3 p-3 rounded-xl bg-softred text-white hover:cursor-pointer">
            <fa icon="fas fa-door-open" fixed-width class="text-sm"></fa>
            <p class="text-sm">Logout</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col w-[85%] h-full overflow-hidden bg-softcream rounded-xl">
      <RouterView :key="route.path" />
    </div>
  </div>

  <!-- <div class="bg-leafgreen w-screen h-screen flex items-center flex-col px-10 py-6 gap-6 overflow-hidden">
    <div class="bg-white rounded-xl px-10 py-6 w-full flex items-center justify-between">
      <img src="@/assets/icon.png" class="w-[6%]">
      <div class="flex items-center gap-5">
        <div>
          <p class="text-right text-lg font-semibold">{{ role == 'Dosen' ? sessionStore.session.acc.nm_dosen : sessionStore.session.acc.nm_mhswa }}</p>
          <p class="text-right text-sm">{{ role }}</p>
        </div>
        <img src="@/assets/fp.png" class="w-16">
      </div>
    </div>
    <div class="bg-white rounded-xl px-10 py-5 w-full h-full max-h-full overflow-hidden flex flex-col items-center justify-center">
      <div name="routerDosen" class="flex gap-5 py-3 border-b-[1px] border-b-leafgreen w-full" v-if="role == 'Dosen'">
        <RouterLink to="/dashboard/dosen/mahasiswa">
          <p class="text-sm font-medium">Data Mahasiswa</p>
        </RouterLink>
        <RouterLink to="/">
          <p class="text-sm font-medium">Data Status Absensi</p>
        </RouterLink>
        <RouterLink to="/">
          <p class="text-sm font-medium">Data Akun</p>
        </RouterLink>
        <RouterLink to="/">
          <p class="text-sm font-medium">Data Kelas</p>
        </RouterLink>
        <RouterLink to="/">
          <p class="text-sm font-medium">Data Prodi</p>
        </RouterLink>
        <RouterLink to="/">
          <p class="text-sm font-medium">Data Matkul</p>
        </RouterLink>
      </div>
      <div class="py-5 w-full h-full overflow-hidden">
        <RouterView></RouterView>
      </div>
    </div>
  </div> -->
</template>
