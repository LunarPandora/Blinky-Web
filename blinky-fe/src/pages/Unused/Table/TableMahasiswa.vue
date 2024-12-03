<script setup>
    import {ref, onMounted} from 'vue'
    import apiClient from '@/services/api'

    import TambahMahasiswa from '../Form/Mahasiswa/TambahMahasiswa.vue';
    import EditMahasiswa from '../Form/Mahasiswa/EditMahasiswa.vue';
    import HapusMahasiswa from '../Form/Mahasiswa/HapusMahasiswa.vue';

    const dataMahasiswa = ref()
    const dataKelas = ref()
    const dataProdi = ref()

    const isModalOn = ref(false)
    const formType = ref('Tambah')

    const selectedData = ref()

    onMounted(() => {
        fetchData()
    })

    function fetchData(){
        dataMahasiswa.value = []
        dataKelas.value = []
        dataProdi.value = []

        apiClient.get('/api/mahasiswa').then(resp => {
            dataMahasiswa.value = resp.data
        })

        apiClient.get('/api/kelas').then(resp => {
            dataKelas.value = resp.data
        })

        apiClient.get('/api/prodi').then(resp => {
            dataProdi.value = resp.data
        })
    }

    function toggleModal(btn, data){
        isModalOn.value = !isModalOn.value
        if(btn != 'Tambah'){
            selectedData.value = data
        }

        formType.value = btn
        
        if(!isModalOn.value){
            fetchData();
        }
    }
    
</script>

<template>
    <div class="bg-[#000000AA] h-screen w-screen z-30 fixed top-0 left-0" :class="{'flex items-center justify-center' : isModalOn, 'hidden' : !isModalOn}">
        <div class="bg-white p-10 rounded-xl flex flex-col items-center justify-center w-5/12">
            <div class="flex items-center justify-between w-full pb-10">
                <p class="text-2xl font-semibold text-indigo">{{ formType }} Mahasiswa</p>
                
                <button @click="toggleModal()">
                    <fa icon="fas fa-times" class="text-3xl text-indigo"></fa>
                </button>
            </div>

            <TambahMahasiswa v-if="formType == 'Tambah'" />
            <EditMahasiswa v-if="formType == 'Edit'" :selected-data="selectedData" />
            <HapusMahasiswa v-if="formType == 'Hapus'" :selected-data="selectedData" />
        </div>
    </div>
    <div class="flex flex-col w-full h-full justify-between">
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-center py-2 w-full">
                <div class="w-1/3 flex gap-3 items-center justify-start">
                    <fa icon="fas fa-user-graduate" class="text-3xl text-indigo"></fa>
                    <p class="text-lg font-semibold text-indigo">Data Mahasiswa</p>
                </div>

                <div class="w-1/3 flex gap-3 items-center justify-center">
                    <div class="flex p-3 bg-gray-200 rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-search" class="text-gray-600"></fa>
                        <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari nama mahasiswa...">
                    </div>
                </div>

                <div class="w-1/3 flex gap-3 items-center justify-end">
                    <div class="flex p-3 bg-indigo rounded-lg items-center gap-2 max-w-[35%]">
                        <fa icon="fas fa-book" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full">
                            <option selected value="0">Semua kelas</option>
                            <option v-for="x in dataKelas" :value="x.id_kelas">{{ x.nm_kelas }}</option>
                        </select>
                    </div>

                    <div class="flex p-3 bg-indigo rounded-lg items-center gap-2 max-w-[35%]">
                        <fa icon="fas fa-graduation-cap" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full">
                            <option selected value="0">Semua prodi</option>
                            <option v-for="x in dataProdi" :value="x.id_prodi">{{ x.nm_prodi }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-y-scroll h-full max-h-full mt-3">
            <table class="w-full border-separate">
                <thead>
                    <tr class="*:p-3 *:border-y-2 *:text-left sticky top-0 bg-white">
                        <th width="10%">NIM</th>
                        <th width="15%">Nama</th>
                        <th width="10%">Kelas</th>
                        <th width="17.5%">Prodi</th>
                        <th width="10%">Angkatan</th>
                        <th width="17.5%">Terakhir kali diedit</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="*:odd:bg-white *:even:bg-slate-50 *:p-3" v-for="x in dataMahasiswa">
                        <td>{{ x.id_mhswa }}</td>
                        <td>{{ x.nm_mahasiswa }}</td>
                        <td>{{ x.nm_kelas }}</td>
                        <td>{{ x.nm_prodi }}</td>
                        <td>{{ x.angkatan }}</td>
                        <td>{{ x.tgl_diupdate }}</td>
                        <td>
                            <div class="flex gap-2">
                                <button @click="toggleModal('Edit', x)" class="px-5 py-2 text-white font-semibold rounded-md bg-yellow-500 flex items-center gap-3">
                                    <fa icon="fas fa-edit"></fa>
                                    Edit
                                </button>
                                <button @click="toggleModal('Hapus', x)" class="px-5 py-2 text-white font-semibold rounded-md bg-red-500 flex items-center gap-3">
                                    <fa icon="fas fa-trash"></fa>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="flex w-full justify-between items-center border-t-2 pt-5">
            <div>
                <p class="font-semibold text-sm">Jumlah mahasiswa untuk kelas ini : <span class="font-bold">X</span> orang</p>
                <p class="font-semibold text-sm">Jumlah mahasiswa untuk prodi ini : <span class="font-bold">X</span> orang</p>
                <p class="font-semibold text-sm">Total mahasiswa yang terdaftar : <span class="font-bold">X</span> orang</p>
            </div>
            <div>
                <button class="px-5 py-3 text-white font-semibold rounded-md bg-blue-500 flex items-center gap-3" @click="toggleModal('Tambah')">
                    <fa icon="fas fa-user-graduate" fixed-width class="text-2xl"></fa>
                    <p>Tambahkan mahasiswa baru</p>
                </button>
            </div>
        </div>
    </div>
</template>