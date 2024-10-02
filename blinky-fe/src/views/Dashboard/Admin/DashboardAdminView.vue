<script setup>
	import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div class="bg-indigo w-screen h-screen flex items-center flex-col px-10 py-6 gap-6 overflow-hidden">
    <div class="bg-white rounded-xl px-10 py-6 w-full flex items-center justify-between">
      <img src="@/assets/icon.png" class="w-[6%]">
      <div class="flex items-center gap-5">
        <div>
          <p class="text-right text-lg font-semibold">Ruth Evermore, S. Pd.</p>
          <p class="text-right text-sm">Admin</p>
        </div>
        <img src="@/assets/fp.png" class="w-16">
      </div>
    </div>
    <div class="bg-white rounded-xl px-10 py-5 w-full h-full max-h-full overflow-hidden flex flex-col items-center justify-center">
      <div name="router" class="flex gap-5 py-3 border-b-[1px] border-b-indigo w-full">
        <RouterLink to="/dashboard/admin/mahasiswa">
          <p class="text-sm font-medium">Data Mahasiswa</p>
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
        <RouterLink to="/">
          <p class="text-sm font-medium">Data Status Absensi</p>
        </RouterLink>
      </div>
      <div class="py-5 w-full h-full overflow-hidden">
        <RouterView></RouterView>
      </div>
    </div>
  </div>
</template>
