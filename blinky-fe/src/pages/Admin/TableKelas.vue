<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRoute } from 'vue-router'

    import DateConverter from '@/services/date'
    import apiClient from '@/services/api';

    const dataKelas = ref()
    const temp_data = ref()

    const kelas = ref()

    const isModalOn = ref(false)
    const modalMode = ref('Add')

    async function fetchData(){
        await apiClient.get('kelas')
        .then(resp => {
            dataKelas.value = resp.data
        })
    }

    async function resetInput(){
        kelas.value = ''
    }

    async function tambahKelas(){
        await apiClient.get('kelas/add', {
            params: {
                'nm_kelas': kelas.value
            }
        })
        .then(resp => {
            if(resp.data == "Success!"){
                alert('Data jurusan berhasil didaftarkan!')
            }
            else{
                alert('Data jurusan gagal didaftarkan!')
            }

            resetInput()
            toggleModal(0, 'Add')
        })
    }

    async function updateKelas(){
        await apiClient.get('kelas/update', {
            params: {
                'id_kelas': temp_data.value.id_kelas,
                'nm_kelas': kelas.value
            }
        })
        .then(resp => {
            if(resp.data == "Success!"){
                alert('Data kelas berhasil diupdate!')
            }
            else{
                alert('Data kelas gagal diupdate!')
            }

            toggleModal(0, 'Edit')
        })
    }

    async function deleteKelas(){
        await apiClient.get('kelas/delete', {
            params: {
                'id_kelas': temp_data.value.id_kelas,
            }
        })
        .then(resp => {
            if(resp.data == "Success!"){
                alert('Data kelas berhasil dihapus!')
            }
            else{
                alert('Data kelas gagal dihapus!')
            }

            toggleModal(0, 'Delete')
        })
    }

    function toggleModal(val, mode){
        isModalOn.value = !isModalOn.value
        modalMode.value = mode

        temp_data.value = val
        
        if(mode == 'Edit'){
            kelas.value = val.nm_kelas
        }
        else{
            resetInput()
        }

        fetchData()
    }

    onMounted(() => {
        fetchData()
    })
</script>

<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-darkbrown font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Kelas
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200">
        <div class="flex p-2 bg-cream rounded-lg items-center gap-3 w-[30%] text-sm leading-relaxed tracking-wide">
            <fa icon="fas fa-search" class="text-darkbrown"></fa>
            <input class="bg-transparent border-0 outline-none w-full placeholder:text-darkbrown" type="text" placeholder="Cari kelas...">
        </div>

        <div class="flex items-center justify-end gap-5">
            <button @click="toggleModal(0, 'Add')" class="flex gap-2 items-center p-2 leading-relaxed tracking-wide text-sm bg-darkbrown text-white rounded-lg">
                <fa icon="fas fa-plus"></fa>
                Tambahkan kelas baru
            </button>
        </div>
    </div>
    <div class="flex flex-col w-full h-full overflow-y-scroll justify-between px-5 my-4 scrollbar">
        <table class="w-full">
            <thead>
                <tr class="*:p-3 *:text-left *:font-medium sticky top-0 bg-darkbrown text-white">
                    <th width="65%" class="rounded-tl-lg">Nama Kelas</th>
                    <th width="20%">Terakhir kali diedit</th>
                    <th width="10%" class="rounded-tr-lg">Action</th>
                </tr>
            </thead>
            <tbody>
                <TransitionGroup name="fade" mode="out-in">
                    <tr class="bg-white odd:bg-[#f5f1e4] border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide" v-for="(x, index) in dataKelas" :key="index" v-if="dataKelas">
                        <td>{{ x.nm_kelas }}</td>
                        <td>{{ new DateConverter(x.updated_at).format() }}</td>
                        <td class="text-white justify-center h-full">
                            <div class="flex items-center gap-1">
                                <button class="bg-orange-400 p-2 rounded-lg h-fit" @click="toggleModal(x, 'Edit')">
                                    <fa icon="fas fa-edit" fixed-width></fa>
                                </button>

                                <button class="bg-red-600 p-2 rounded-lg h-fit" @click="toggleModal(x, 'Delete')">
                                    <fa icon="fas fa-trash" fixed-width></fa>
                                </button>
                            </div>
                            <!-- <div class="flex p-2 bg-indigo rounded-lg items-center gap-2 h-fit">
                                <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full text-sm" :value="x.kode_status_absensi" :id="'select-' + index" @change="updateStatus(x, index)">
                                    <option v-for="y in dataStatus" :value="y.kode_status_absensi">{{ y.status_absensi}}</option>
                                </select>
                            </div>

                            <button @click="toggleModal(x)" class="flex p-2 bg-orange-400 rounded-lg items-center gap-2 h-fit">
                                <fa icon="fas fa-edit"></fa>
                                Keterangan
                            </button> -->
                        </td>
                    </tr>
                </TransitionGroup>
            </tbody>
        </table>
    </div>
    <TransitionGroup name="fade" mode="out-in">
        <div class="items-center justify-center w-screen h-screen bg-[#000000AA] z-50 absolute top-0 left-0 flex" v-if="isModalOn">
            <div class="flex flex-col bg-cream px-5 py-7 rounded-xl gap-4 w-1/3 justify-center" v-if="modalMode == 'Add'">
                <div class="flex w-full items-center justify-between pb-6">
                    <p class="text-2xl font-medium text-darkbrown">Tambah Kelas</p>

                    <fa @click="toggleModal(0, 'Add')" icon="fas fa-times" class="text-2xl" fixed-width></fa>
                </div>

                <div class="flex flex-col gap-8">
                    <div class="flex flex-col items-center w-full justify-center gap-3">
                        <div class="bg-softcream p-4 rounded-xl flex items-center w-full gap-3">
                            <fa icon="fas fa-door-closed" class="text-darkbrown" fixed-width />
                            <input type="text" class="bg-transparent outline-none w-full" v-model="kelas" placeholder="Masukkan nama kelas">
                        </div>

                        <button @click="tambahKelas()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-leafgreen text-white rounded-lg">
                            <fa icon="fas fa-plus"></fa>
                            Tambahkan
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col bg-cream px-5 py-7 rounded-xl gap-4 w-1/3 justify-center" v-if="modalMode == 'Edit'">
                <div class="flex w-full items-center justify-between pb-6">
                    <p class="text-2xl font-medium text-darkbrown">Edit Kelas</p>

                    <fa @click="toggleModal(0, 'Edit')" icon="fas fa-times" class="text-2xl" fixed-width></fa>
                </div>

                <div class="flex flex-col gap-8">
                    <div class="flex flex-col items-center w-full justify-center gap-3">
                        <div class="bg-softcream p-4 rounded-xl flex items-center w-full gap-3">
                            <fa icon="fas fa-door-closed" class="text-darkbrown" fixed-width />
                            <input type="text" class="bg-transparent outline-none w-full" v-model="kelas" placeholder="Masukkan nama kelas">
                        </div>

                        <button @click="updateKelas()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-leafgreen text-white rounded-lg">
                            <fa icon="fas fa-floppy-disk"></fa>
                            Update
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col bg-cream px-5 py-7 rounded-xl w-1/3 justify-center" v-if="modalMode == 'Delete'">
                <div class="flex w-full items-center justify-between pb-6">
                    <p class="text-2xl font-medium text-darkbrown">Hapus Kelas</p>
                </div>

                <div class="flex flex-col gap-2">
                    <p class="text-l text-darkbrown">Apakah anda yakin ingin menghapus data ini?</p>
                    <div class="flex flex-row items-center w-full justify-center gap-3">
                        <button @click="toggleModal(0, 'Delete')" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-transparent outline outline-darkbrown [outline-offset:-2.5px] text-darkbrown rounded-lg">
                            Tidak
                        </button>

                        <button @click="deleteKelas()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-softred text-white rounded-lg">
                            Ya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </TransitionGroup>
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