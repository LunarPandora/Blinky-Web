<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRoute } from 'vue-router'

    import DateConverter from '@/services/date'
    import apiClient from '@/services/api';

    const route = useRoute()

    const jadwal = ref()

    const dataAbsensi = ref()
    const dataStatus = ref()

    const search = ref()
    
    const ket = ref()
    const temp_mhs = ref()

    const isModalOn = ref(false)

    onMounted(() => {
        fetchData()
    })

    watch(search, (x, y) => {
        fetchData()
    })

    async function fetchData(){
        await apiClient.get('absensi/list', {
            params: {
                id_pertemuan: route.params.id_pertemuan,
                search: search.value
            }
        })
        .then(resp => {
            dataAbsensi.value = resp.data
        })

        await apiClient.get('jadwal/find', {
            params: {
                id_jadwal: route.params.id_jadwal,
            }
        })
        .then(resp => {
            jadwal.value = resp.data
        })
        
        await apiClient.get('statusabsensi')
        .then(resp => {
            dataStatus.value = resp.data
        })
    }

    function toggleModal(val){
        isModalOn.value = !isModalOn.value
        temp_mhs.value = val

        ket.value = val.keterangan

        fetchData()
    }

    // Update keterangan
    async function editKeterangan(){
        await apiClient.get('absensi/update_ket', {
            params: {
                id_absensi: temp_mhs.value.id_absensi,
                keterangan: ket.value
            }
        })
        .then(resp => {
            if(resp.data == 'Success!'){
                alert("Keterangan absensi berhasil diupdate!")
            }
            else{
                alert("Keterangan absensi gagal diupdate!")
            }

            ket.value = ""
            toggleModal(0)
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
                <span v-if="route.params.pertemuan">Pertemuan ke-{{ route.params.pertemuan }}</span>
            </h1>
        </div>
    </div>
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200">
        <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] leading-relaxed tracking-wide text-sm">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari nama mahasiswa..." v-model="search">
        </div>

        <div class="flex items-center justify-end gap-5">
            <!-- <button @click="toggleModal('add')" class="flex gap-2 items-center p-2 leading-relaxed tracking-wide text-sm bg-blue-500 text-white rounded-lg">
                <fa icon="fas fa-plus"></fa>
                Tambahkan absensi baru
            </button> -->
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
                <TransitionGroup name="fade" mode="out-in">
                <!-- <tr class="*:odd:bg-gray- *:even:bg-blueprism text-white *:p-3"></tr> -->
                    <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide" v-for="(x, index) in dataAbsensi" :key="index" v-if="dataAbsensi">
                        <td>{{ x.mahasiswa.nim }}</td>
                        <td>{{ x.mahasiswa.nm_mhswa }}</td>
                        <td>{{ x.mahasiswa.angkatan }}</td>
                        <td>{{ x.waktu_absen != null ? new DateConverter(x.waktu_absen).format() : "Belum mengisi absen" }}</td>    
                        <td class="flex gap-2 text-white items-center">
                            <div class="flex p-2 bg-indigo rounded-lg items-center gap-2 h-fit">
                                <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full text-sm" :value="x.kode_status_absensi" :id="'select-' + index" @change="updateStatus(x, index)">
                                    <option v-for="y in dataStatus" :value="y.kode_status_absensi">{{ y.status_absensi}}</option>
                                </select>
                            </div>

                            <button @click="toggleModal(x)" class="flex p-2 bg-orange-400 rounded-lg items-center gap-2 h-fit">
                                <fa icon="fas fa-edit"></fa>
                                Keterangan
                            </button>
                        </td>
                    </tr>
                </TransitionGroup>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-10 *:text-sm *:tracking-wide" v-if="!dataAbsensi">
                    <td colspan="5" class="text-center">
                        <p class="pb-5">Harap menunggu...</p>
                        <fa icon="fas fa-spinner" spin class="text-3xl"></fa>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="items-center justify-center w-screen h-screen bg-[#000000AA] z-50 absolute top-0 left-0 flex" v-if="isModalOn">
        <div class="flex flex-col bg-white px-5 py-7 rounded-xl gap-4 w-1/3 justify-center">
            <div class="flex w-full items-center justify-between pb-6">
                <p class="text-2xl font-medium text-indigo">Edit Keterangan</p>

                <fa @click="toggleModal(0)" icon="fas fa-times" class="text-2xl" fixed-width></fa>
            </div>

            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center w-full justify-center gap-3">
                    <div class="bg-indigo p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-white" fixed-width />
                        <p class="text-white">{{ temp_mhs.mahasiswa.nm_mhswa }}</p>
                    </div>
                    <div class="bg-gray-300 p-4 rounded-xl flex flex-col justify-center w-full gap-3">
                        <p class="flex gap-3 items-center">
                            <fa icon="fas fa-clipboard" class="text-gray-500" fixed-width />
                            <p class="text-gray-500 font-medium">Keterangan</p>
                        </p>

                        <textarea class="bg-transparent outline-none overflow-hidden text-sm h-32 resize-none" placeholder="Masukkan catatan disini..." v-model="ket"></textarea>
                    </div>

                    <button @click="editKeterangan()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-indigo text-white rounded-lg">
                        <fa icon="fas fa-floppy-disk"></fa>
                        Perbarui
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

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.5s ease;
    }

    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
</style>