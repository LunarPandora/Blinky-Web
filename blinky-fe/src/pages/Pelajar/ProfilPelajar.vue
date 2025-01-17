<script setup>
</script>
<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-indigo font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Profil
            </h1>
        </div>
    </div>  
    <!-- <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200 bg-white">
        <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] text-sm leading-relaxed tracking-wide">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari nama mata kuliah...">
        </div> -->
        <!-- Bagian untuk searchbar, dsb
    </div> -->
    <div class="grid grid-cols-3 gap-3 w-full h-full p-5 overflow-y-scroll scrollbar">
        <!-- Isi halaman disini -->
         <div class="flex-col justify-items-center">
            <img src="../../assets/profildosen.jpg" class="w-48 h-48 rounded-full my-5 object-cover">
            <h3 class="text-indigo font-medium text-lg">Ganti Profil</h3>
         </div>
         <div class="flex-col my-5">
            <h3 class="text-indigo font-medium text-md">Nama</h3>
            <h3 class="text-black font-light text-md mb-4">Rudi Mahasiswa</h3>
            <h3 class="text-indigo font-medium text-md">NIM</h3>
            <h3 class="text-black font-light text-md mb-4">22100099</h3>
            <h3 class="text-indigo font-medium text-md">Prodi</h3>
            <h3 class="text-black font-light text-md mb-4">Sistem dan Teknologi Informasi</h3>
            <h3 class="text-indigo font-medium text-md">Angkatan</h3>
            <h3 class="text-black font-light text-md mb-4">2022</h3>
         </div>
         <div class="flex-col my-5">
            <h3 class="text-indigo font-medium text-md">Email</h3>
            <h3 class="text-black font-light text-md mb-4">rudi@gmail.com</h3>
            <h3 class="text-indigo font-medium text-md">Password</h3>

            <div class="flex items-center">
                <h3 class="text-black font-light text-md mb-4">••••••••</h3>
                <!-- Ikon Ganti Password -->
                <fa icon="fas fa-edit" fixed-width class="text-md text-indigo ml-4 mb-4"></fa>
            </div>
         </div>
    </div>
</template>