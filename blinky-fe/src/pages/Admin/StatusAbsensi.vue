<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-indigo font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Status Absensi
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200 bg-white">
        <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] text-sm leading-relaxed tracking-wide">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari status absensi...">
        </div>

        <div class="flex items-center justify-end gap-5">
            <button @click="toggleModal('add')" class="flex gap-2 items-center p-2 leading-relaxed tracking-wide text-sm bg-blue-500 text-white rounded-lg">
                <fa icon="fas fa-plus"></fa>
                Tambahkan status absensi baru
            </button>
            <!-- <div class="flex p-3 bg-indigo rounded-lg items-center gap-2 max-w-[50%]">
                <fa icon="fas fa-door-closed" class="text-white"></fa>
                <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="kelas">
                    <option selected value="0">Semua kelas</option>
                    <option v-for="x in dataKelas" :value="x.id_kelas">{{ x.nm_kelas }}</option>
                </select>
            </div> -->

            <!-- <div class="flex p-3 bg-indigo rounded-lg items-center gap-2">
                <fa icon="fas fa-book" class="text-white"></fa>
                <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="hari">
                    <option selected value="0">Semua hari</option>
                    <option v-for="x in 6" :value="x">{{ new DayFormatter(x).convertToDayName() }}</option>
                </select>
            </div> -->
        </div>
    </div>
    <div class="flex flex-col w-full h-full overflow-y-scroll justify-between px-5 my-4 scrollbar">
        <table class="w-full">
            <thead>
                <tr class="*:p-3 *:border-y-2 *:text-left *:font-medium sticky top-0 bg-indigo text-white *:text-center">
                    <th width="90%">Status Absensi</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Hadir</td>
                    <td><fa icon="fas fa-edit"></fa> <fa icon="fas fa-trash"></fa></td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Tidak Hadir</td>
                    <td><fa icon="fas fa-edit"></fa> <fa icon="fas fa-trash"></fa></td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Izin</td>
                    <td><fa icon="fas fa-edit"></fa> <fa icon="fas fa-trash"></fa></td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Sakit</td>
                    <td><fa icon="fas fa-edit"></fa> <fa icon="fas fa-trash"></fa></td>
                </tr>
            </tbody>
        </table>
    </div>

</template>