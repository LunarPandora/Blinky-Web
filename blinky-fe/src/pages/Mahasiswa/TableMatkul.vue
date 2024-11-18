<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-indigo font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Mata Kuliah
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200 bg-white">
        <!-- <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] text-sm leading-relaxed tracking-wide">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari nama mata kuliah...">
        </div> -->
        <!-- Bagian untuk searchbar, dsb -->
    </div>
    <div class="grid grid-cols-3 gap-3 w-full h-full p-5 overflow-y-scroll scrollbar">
        <!-- Isi halaman disini -->
    </div>
</template>