<script setup>
  import { ref, onMounted, watch } from 'vue'
	import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router'

  import apiClient from '@/services/api'
  import { useSessionStore } from '@/stores/session';

  const sessionStore = useSessionStore()
  const route = useRoute()
  const router = useRouter()

  const s = sessionStore.session
  const currentPage = route.path
  const user_pic = ref('')

  watch(currentPage, (x, y) => {
    console.log(x, y)
  })

  onMounted(() => {
    setInterval(() => {
      getUser()
    }, 2000)
  })

  async function getUser(){
    await apiClient.get('users', {
      params: {
        'id': sessionStore.session.id,
      }
    })
    .then(resp => {
      sessionStore.registerSession(resp.data)
      sessionStore.authenticate()
      
      user_pic.value = 'http://localhost:8000/storage/images/' + resp.data.user_picture
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
        <!-- <img v-if="s.user_pic == '-'" src="@/assets/fp.png" class="rounded-md w-1/6">
        <img v-else src="" class="rounded-md w-1/6"> -->

        <div class="w-10 h-10 overflow-hidden flex items-center justify-center rounded-full">
          <img v-if="s.user_pic == '-'" src="@/assets/fp.png">
          <img v-else :src="user_pic">
        </div>

        <div class="flex flex-col justify-center">
          <p class="font-medium text-xs">{{ s.email }}</p>
          <p class="text-xs" v-if="s.role == 'Pengajar'">{{ s.pengajar.tipe_pengajar }}</p>
          <p class="text-xs" v-else-if="s.role == 'Pelajar'">{{ s.pelajar.tipe_pelajar }}</p>
          <p class="text-xs" v-else>Admin</p>
        </div>
      </div>

      <div class="flex flex-col h-full items-start justify-between pt-3">
        <p class="font-medium text-sm text-darkbrown pb-2">Menu</p>

        <div name="navbar_admin" class="flex flex-col w-full h-full gap-2" v-if="sessionStore.session.role == 'Admin'">
          <RouterLink to='/dashboard/admin/pelajar' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-user-graduate" fixed-width class="text-xl"></fa>
            <p class="text-sm">Pelajar</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/users' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-users" fixed-width class="text-xl"></fa>
            <p class="text-sm">User</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/jurusan' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-school" fixed-width class="text-xl"></fa>
            <p class="text-sm">Jurusan</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/jadwal' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-calendar" fixed-width class="text-xl"></fa>
            <p class="text-sm">Jadwal</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/kelas' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-door-closed" fixed-width class="text-xl"></fa>
            <p class="text-sm">Kelas</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/pengajar' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-graduation-cap" fixed-width class="text-xl"></fa>
            <p class="text-sm">Pengajar</p>
          </RouterLink>

          <RouterLink to='/dashboard/admin/mata_studi' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-book" fixed-width class="text-xl"></fa>
            <p class="text-sm">Mata Studi</p>
          </RouterLink>
        </div>

        <div name="navbar_pengajar" class="flex flex-col w-full h-full gap-1" v-if="sessionStore.session.role == 'Pengajar'">
          <RouterLink to='/dashboard/pengajar/mata_studi' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-school" fixed-width class="text-md"></fa>
            <p class="text-sm">Mata Studi</p>
          </RouterLink>

          <RouterLink to='/dashboard/pengajar/profil' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-user" fixed-width class="text-md"></fa>
            <p class="text-sm">Profil Pengajar</p>
          </RouterLink>
        </div>

        <div name="navbar_mhswa" class="flex flex-col w-full h-full gap-5" v-if="sessionStore.session.role == 'Pelajar'">
          <RouterLink to='/dashboard/pelajar/mata_studi' class="flex items-center gap-3 p-3 rounded-lg transition-all hover:bg-softbrown text-darkbrown" active-class="bg-leafgreen *:text-white hover:bg-leafgreen">
            <fa icon="fas fa-school" fixed-width class="text-md"></fa>
            <p class="text-sm">Mata Studi</p>
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
          <p class="text-right text-lg font-semibold">{{ role == 'Pengajar' ? sessionStore.session.acc.nm_pengajar : sessionStore.session.acc.nm_mhswa }}</p>
          <p class="text-right text-sm">{{ role }}</p>
        </div>
        <img src="@/assets/fp.png" class="w-16">
      </div>
    </div>
    <div class="bg-white rounded-xl px-10 py-5 w-full h-full max-h-full overflow-hidden flex flex-col items-center justify-center">
      <div name="routerPengajar" class="flex gap-5 py-3 border-b-[1px] border-b-leafgreen w-full" v-if="role == 'Pengajar'">
        <RouterLink to="/dashboard/pengajar/pelajar">
          <p class="text-sm font-medium">Data Pelajar</p>
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
          <p class="text-sm font-medium">Data Jurusan</p>
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
