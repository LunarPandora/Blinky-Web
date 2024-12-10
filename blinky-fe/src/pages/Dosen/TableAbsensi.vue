<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRoute } from 'vue-router'

    import DateConverter from '@/services/date'
    import apiClient from '@/services/api';

    const route = useRoute()

    const dataAbsensi = ref()
    const dataMahasiswa = ref()
    const dataStatus = ref()

    const jadwal = ref()
    const mahasiswa = ref(0)
    const status = ref(0)
    const date = ref()
    const time = ref(new Date())

    const temp_id = ref()
    
    const isModalOn = ref(false)
    const modeModal = ref()

    onMounted(() => {
        fetchData()
    })

    async function fetchData(){
        await apiClient.get('pertemuan/find', {
            params: {
                id_pertemuan: route.params.id_pertemuan
            }
        })
        .then(resp => {
            console.log(resp.data)
            dataAbsensi.value = resp.data
        })

        // await apiClient.get('jadwal/find', {
        //     params: {
        //         id_jadwal: route.params.id_jadwal,
        //     }
        // })
        // .then(resp => {
        //     jadwal.value = resp.data[0]
        // })

        // await apiClient.get('mahasiswa/list', {
        //     params: {
        //         id_kelas: jadwal.value.kelas.id_kelas,
        //     }
        // })
        // .then(resp => {
        //     dataMahasiswa.value = resp.data
        // })
        
        // await apiClient.get('statusabsensi')
        // .then(resp => {
        //     dataStatus.value = resp.data
        // })
    }

    function toggleModal(mode, val){
        isModalOn.value = !isModalOn.value
        modeModal.value = mode

        if(mode == 'delete'){
            temp_id.value = val
        }

        fetchData()
    }

    // Template cara tambah / edit / update data
    async function editAbsensi(){
        await apiClient.get('absensi/update', {
            params: {
                id_mhswa: mahasiswa.value,
                id_jadwal: route.params.id_jadwal,
                id_kelas: jadwal.value.kelas.id_kelas,
                date: date.value,
                time: time.value,
                kode_status_absensi: status.value,
                pertemuan: route.params.id_tanggal
            }
        })
        .then(resp => {
            if(resp.data == 'Success!'){
                alert("Absensi berhasil diupdate!")
            }
            else{
                alert("Absensi gagal diupdate!")
            }
        })
    }

    async function tambahAbsensi(){
        await apiClient.get('absensi/add', {
            params: {
                id_mhswa: mahasiswa.value,
                id_jadwal: route.params.id_jadwal,
                id_kelas: jadwal.value.kelas.id_kelas,
                date: date.value,
                time: time.value,
                kode_status_absensi: status.value,
                pertemuan: route.params.id_tanggal
            }
        })
        .then(resp => {
            if(resp.data == 'Success!'){
                alert('Absensi berhasil ditambahkan!')
            }
            else{
                alert('Absensi gagal ditambahkan!')
            }

            toggleModal('', 0)
        })
    }

    async function updateStatus(x, index){
        let newStatus = document.getElementById('select-' + index).value

        await apiClient.get('absensi/update', {
            params: {
                id_absensi: x.id_absensi,
                kode_status_absensi: newStatus,
            }
        })
        .then(resp => {
            if(resp.data == 'Success!'){
                alert('Absensi berhasil diupdate!')
            }
            else{
                alert('Absensi gagal diupdate!')
            }
        })
    }

    async function hapusAbsensi(){
        await apiClient.get('absensi/delete', {
            params: {
                id_absensi: temp_id.value,
            }
        })
        .then(resp => {
            if(resp.data == 'Success!'){
                alert('Absensi berhasil dihapus!')
            }
            else{
                alert('Absensi gagal dihapus!')
            }

            toggleModal('', 0)
        })    
    }
</script>

<template>
    <div class="flex items-center justify-between bg-keppel sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-indigo font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Mata Kuliah
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                <span v-if="jadwal">{{ jadwal.matkul.nm_matkul }} - {{ jadwal.kelas.nm_kelas }}</span>
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                <span v-if="route.params.id_tanggal">Pertemuan ke-{{ route.params.id_tanggal }}</span>
            </h1>
        </div>
    </div>
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200">
        <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] leading-relaxed tracking-wide text-sm">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari nama mata kuliah...">
        </div>

        <div class="flex items-center justify-end gap-5">
            <button @click="toggleModal('add')" class="flex gap-2 items-center p-2 leading-relaxed tracking-wide text-sm bg-blue-500 text-white rounded-lg">
                <fa icon="fas fa-plus"></fa>
                Tambahkan absensi baru
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
                <tr class="*:p-3 *:border-y-2 *:text-left *:font-medium sticky top-0 bg-indigo text-white">
                    <th width="15%">NIM</th>
                    <th width="35%">Nama</th>
                    <th width="5%">Angkatan</th>
                    <th width="25%">Terakhir kali diedit</th>
                    <th width="20%">Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr class="*:odd:bg-gray- *:even:bg-blueprism text-white *:p-3"></tr> -->
                <!-- <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide" v-for="(x, index) in dataAbsensi" :key="index">
                    <td>{{ x.mahasiswa.nim }}</td>
                    <td>{{ x.mahasiswa.nm_mhswa }}</td>
                    <td>{{ x.mahasiswa.angkatan }}</td>
                    <td>{{ new DateConverter(x.waktu_absen).format() }}</td>
                    <td class="flex gap-2 text-white items-center">
                        <div class="flex p-2 bg-indigo rounded-lg items-center gap-2 h-fit">
                            <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full text-sm" :value="x.kode_status_absensi" :id="'select-' + index" @change="updateStatus(x, index)">
                                <option v-for="y in dataStatus" :value="y.kode_status_absensi">{{ y.status_absensi}}</option>
                            </select>
                        </div>

                        <button @click="toggleModal('delete', x.id_absensi)" c  lass="flex p-2 bg-red-500 rounded-lg items-center gap-2 h-fit text-sm">
                            <fa icon="fas fa-trash"></fa>
                            <p>Hapus</p>
                        </button>
                    </td>
                </tr> -->
            </tbody>
        </table>
    </div>

    <div class="items-center justify-center w-screen h-screen bg-[#000000AA] z-50 absolute top-0 left-0" :class="isModalOn ? 'flex' : 'hidden'">
        <div class="flex flex-col bg-white px-5 py-7 rounded-xl gap-4 w-1/3 justify-center" v-if="modeModal == 'add'">
            <div class="flex w-full items-center justify-between pb-6">
                <p class="text-2xl font-medium text-indigo">Tambah Absensi Baru</p>

                <fa @click="toggleModal('', 0)" icon="fas fa-times" class="text-2xl" fixed-width></fa>
            </div>

            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center w-full justify-center gap-2">
                    <div class="bg-indigo p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-white" fixed-width />
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full *:font-light" v-model="mahasiswa">
                            <option readonly hidden value="0">Pilih mahasiswa</option>
                            <option v-for="x in dataMahasiswa" :value="x.id_mhswa">{{ x.nm_mhswa }} - {{ x.nim }}</option>
                        </select>
                    </div>
                    <div class="bg-indigo p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-clipboard" class="text-white" fixed-width />
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full *:font-light" v-model="status">
                            <option readonly hidden value="0">Pilih status absensi</option>
                            <option v-for="x in dataStatus" :value="x.kode_status_absensi">{{ x.status_absensi }}</option>
                        </select>
                    </div>

                    <div class="bg-indigo p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-clock" class="text-white" fixed-width />
                        <DatePicker input-class-name="dateInput font-medium text-white" v-model="time" :time-picker="true" :hide-input-icon="true" minutes-increment="5" />
                    </div>

                    <button @click="tambahAbsensi()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-indigo text-white rounded-lg">
                        <fa icon="fas fa-plus"></fa>
                        Tambahkan
                    </button>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col bg-darkpurple text-white px-5 py-7 rounded-xl gap-4 w-1/3 justify-center" v-else>
            <div class="flex w-full items-center justify-between pb-6">
                <p class="text-2xl font-semibold">Hapus</p>

                <fa @click="toggleModal('', 0)" icon="fas fa-times" class="text-white text-2xl" fixed-width></fa>
            </div>

            <div class="flex flex-col gap-8">
                <p class="text-lg">Apakah anda yakin ingin <span class="font-bold text-red-500">menghapus</span> absensi ini?</p>

                <div class="flex gap-3 items-center justify-end">
                    <button class="bg-darkslate px-6 py-3 rounded-xl text-lg text-white" @click="toggleModal('', 0)">
                        Kembali
                    </button>
                    <button class="bg-indigo px-6 py-3 rounded-xl text-lg text-white" @click="hapusAbsensi()">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .dateInput{
        background-color: transparent !important;
        border: 0 !important;
        color: theme('colors.white') !important;
        padding: 0 !important;
    }

    .dp__disabled{
        color: theme('colors.gray.500') !important;
        background: transparent !important;
    }

    .dp__overlay_cell_disabled{
        background-color: theme('colors.red.300') !important;
    }

    .dp__input {
        background-color: transparent !important;
        border: none !important;
    }
</style>