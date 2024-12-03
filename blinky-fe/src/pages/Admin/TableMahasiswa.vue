<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-indigo font-medium text-lg">
                Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Mahasiswa
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200">
        <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] leading-relaxed tracking-wide text-sm">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari nama mahasiswa...">
        </div>

        <div class="flex items-center justify-end gap-5">
            <button @click="toggleModal('add')" class="flex gap-2 items-center p-2 leading-relaxed tracking-wide text-sm bg-blue-500 text-white rounded-lg">
                <fa icon="fas fa-plus"></fa>
                Tambahkan mahasiswa baru
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
                    <th width="20%">Nama</th>
                    <th width="10%">NIM</th>
                    <th width="10%">Kelas</th>
                    <th width="10%">Prodi</th>
                    <th width="10%">Angkatan</th>
                    <th width="15%">Waktu Pendaftaran</th>
                    <th width="15%">Terakhir kali diedit</th>
                    <th width="5%">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Wendy Yansah</td>
                    <td>22100032</td>
                    <td>Pagi</td>
                    <td>STI</td>
                    <td>2022</td>
                    <td>22/07/2022, 09.00 AM</td>
                    <td>22/07/2022, 09.00 AM</td>
                    <td><fa icon="fas fa-edit"></fa>          <fa icon="fas fa-trash"></fa></td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Steve Ariyanto</td>
                    <td>22100016</td>
                    <td>Pagi</td>
                    <td>STI</td>
                    <td>2022</td>
                    <td>22/07/2022, 09.00 AM</td>
                    <td>22/07/2022, 09.00 AM</td>
                    <td><fa icon="fas fa-edit"></fa>          <fa icon="fas fa-trash"></fa></td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Hendi Lapenata</td>
                    <td>22100030</td>
                    <td>Pagi</td>
                    <td>STI</td>
                    <td>2022</td>
                    <td>22/07/2022, 09.01 AM</td>
                    <td>22/07/2022, 09.01 AM</td>
                    <td><fa icon="fas fa-edit"></fa>          <fa icon="fas fa-trash"></fa></td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Kristanto</td>
                    <td>22100031</td>
                    <td>Pagi</td>
                    <td>STI</td>
                    <td>2022</td>
                    <td>22/07/2022, 09.01 AM</td>
                    <td>22/07/2022, 09.01 AM</td>
                    <td><fa icon="fas fa-edit"></fa>          <fa icon="fas fa-trash"></fa></td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Timothy Valentivo</td>
                    <td>22100034</td>
                    <td>Pagi</td>
                    <td>STI</td>
                    <td>2022</td>
                    <td>22/07/2022, 09.02 AM</td>
                    <td>22/07/2022, 09.02 AM</td>
                    <td><fa icon="fas fa-edit"></fa>          <fa icon="fas fa-trash"></fa></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>