<script setup>
  import { ref, onUpdated } from 'vue'
	import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router'

  import apiClient from '@/services/api'
  import { useSessionStore } from '@/stores/session';

  const sessionStore = useSessionStore()
  const route = useRoute()
  const router = useRouter()

  const role = sessionStore.session.role

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
</script>

<template>
  <div class="flex w-full h-screen justify-center p-7 bg-darkslate gap-6">
    <div class="flex w-[15%] h-full flex-col gap-12 sticky top-0 left-0">
      <img src="@/assets/icon.png" class="w-1/2 h-fit">

      <div class="flex flex-col h-full items-center justify-between">
        <div name="navbar" class="flex flex-col w-full h-full gap-5">
          <!-- <RouterLink class="flex items-center gap-3 p-3 rounded-xl">
            <fa icon="fas fa-clock" fixed-width class="text-xl text-white"></fa>
            <p class="font-medium text-white">Jadwal</p>
          </RouterLink> -->
          <RouterLink to='/dashboard/dosen/matkul' class="flex items-center gap-3 p-3 rounded-xl" :active-class="'bg-white *:text-indigo'">
            <fa icon="fas fa-school" fixed-width class="text-xl text-white"></fa>
            <p class="font-medium text-white">Mata Kuliah</p>
          </RouterLink>
          <!-- <RouterLink to='/dashboard/dosen/absensi' class="flex items-center gap-3 p-3 rounded-xl" :active-class="'bg-white *:text-indigo'">
            <fa icon="fas fa-user-graduate" fixed-width class="text-xl text-white"></fa>
            <p class="font-medium text-white">Absensi</p>
          </RouterLink> -->
        </div>
        <div class="flex flex-col w-full gap-5">
          <div @click="logout()" class="flex items-center gap-3 p-3 rounded-xl bg-indigo">
            <fa icon="fas fa-door-open" fixed-width class="text-xl text-white"></fa>
            <p class="font-medium text-white">Logout</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col w-[85%] bg-darkpurple rounded-xl">
      <RouterView :key="route.path" />
    </div>
  </div>

  <!-- <div class="bg-indigo w-screen h-screen flex items-center flex-col px-10 py-6 gap-6 overflow-hidden">
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
      <div name="routerDosen" class="flex gap-5 py-3 border-b-[1px] border-b-indigo w-full" v-if="role == 'Dosen'">
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
