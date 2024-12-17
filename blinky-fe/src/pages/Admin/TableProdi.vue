<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRoute } from 'vue-router'

    import apiClient from '@/services/api'
    import DateConverter from '@/services/date'

    const route = useRoute()

    const dataProdi = ref()

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
        await apiClient.get('prodi/list', {
            params: {
                id_jadwal: route.params.id_jadwal,
                pertemuan: route.params.id_tanggal
            }
        })
        .then(resp => {
            dataProdi.value = resp.data
        })
    }

    function toggleModal(mode, val){
        isModalOn.value = !isModalOn.value
        modeModal.value = mode

        if(mode == 'delete'){
            temp_id.value = val
        }

        fetchData()
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
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-indigo font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Prodi
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200 bg-white">
        <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] text-sm leading-relaxed tracking-wide">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari prodi...">
        </div>

        <div class="flex items-center justify-end gap-5">
            <button @click="toggleModal('add')" class="flex gap-2 items-center p-2 leading-relaxed tracking-wide text-sm bg-blue-500 text-white rounded-lg">
                <fa icon="fas fa-plus"></fa>
                Tambahkan prodi baru
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
                    <th width="90%">Nama Prodi</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Sistem & Teknologi Informasi</td>
                    <td><fa icon="fas fa-edit"></fa> <fa icon="fas fa-trash"></fa></td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Bisnis Digital</td>
                    <td><fa icon="fas fa-edit"></fa> <fa icon="fas fa-trash"></fa></td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Kewirausahaan</td>
                    <td><fa icon="fas fa-edit"></fa> <fa icon="fas fa-trash"></fa></td>
                </tr>
            </tbody>
        </table>
    </div>

</template>