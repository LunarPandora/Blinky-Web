<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRoute } from 'vue-router'

    import DateConverter from '@/services/date'
    import apiClient from '@/services/api';

    const dataDosen = ref()
    const dataProdi = ref()
    const temp_data = ref()

    const nama = ref()
    const prodi = ref("0")
    const jabatan = ref()
    const nidn = ref()
    const email = ref()
    const password = ref()

    const isModalOn = ref(false)
    const modalMode = ref('Add')

    async function fetchData(){
        await apiClient.get('dosen')
        .then(resp => {
            console.log(resp.data)
            dataDosen.value = resp.data
        })

        await apiClient.get('prodi')
        .then(resp => {
            dataProdi.value = resp.data
        })
    }

    async function tambahDosen(){
        await apiClient.get('dosen/add', {
            params: {
                'id_prodi': prodi.value,
                'nm_dosen': nama.value,
                'jabatan': jabatan.value,
                'nidn': nidn.value,
                'email': email.value,
                'password': password.value,
            }
        })
        .then(resp => {
            if(resp.data == "Success!"){
                alert('Data dosen berhasil didaftarkan!')
            }
            else{
                alert('Data dosen gagal didaftarkan!')
            }

            toggleModal(0)
        })
    }

    async function updateDosen(){
        await apiClient.get('dosen/update', {
            params: {
                'id_dosen' : temp_data.value.id_dosen,
                'id_prodi' : prodi.value,
                'nm_dosen' : nama.value,
                'jabatan': jabatan.value,
                'nidn': nidn.value,
                'email': email.value,
                'password': password.value,
            }
        })
        .then(resp => {
            console.log(resp.data)

            toggleModal(0, 'Edit')
        })
    }

    async function hapusDosen(x){
        await apiClient.get('dosen/delete', {
            params: {
                'id_dosen': x.id_dosen,
            }
        })
        .then(resp => {
            if(resp.data == "Success!"){
                alert('Data dosen berhasil dihapus!')
                fetchData();
            }
            else{
                alert('Data dosen gagal dihapus!')
            }

            toggleModal(0, 'Delete')
        })
    }

    function toggleModal(val, mode){
        isModalOn.value = !isModalOn.value
        modalMode.value = mode

        temp_data.value = val

        if(mode == 'Edit'){
            prodi.value = val.id_prodi
            nama.value = val.nm_dosen
            jabatan.value = val.jabatan
            nidn.value = val.nidn
            email.value = val.email
            password.value = val.password
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
            <h1 class="text-indigo font-medium text-lg">
                Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Dosen
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200">
        <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] leading-relaxed tracking-wide text-sm">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari nama dosen...">
        </div>

        <div class="flex items-center justify-end gap-5">
            <button @click="toggleModal('Add')" class="flex gap-2 items-center p-2 leading-relaxed tracking-wide text-sm bg-blue-500 text-white rounded-lg">
                <fa icon="fas fa-plus"></fa>
                Tambahkan dosen baru
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
                    <th width="10%">NIDN</th>
                    <th width="10%">Jabatan</th>
                    <th width="10%">Prodi</th>
                    <th width="15%">Waktu Pendaftaran</th>
                    <th width="15%">Terakhir kali diedit</th>
                    <th width="5%">Action</th>
                </tr>
            </thead>
            <tbody>
                <TransitionGroup name="fade" mode="out-in">
                    <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide" v-for="(x, index) in dataDosen" :key="index" v-if="dataDosen">
                        <td>{{ x.nm_dosen }}</td>
                        <td>{{ x.nidn }}</td>
                        <td>{{ x.jabatan }}</td>
                        <td>{{ x.prodi.nm_prodi }}</td>
                        <td>{{ new DateConverter(x.created_at).format() }}</td>
                        <td>{{ new DateConverter(x.updated_at).format() }}</td>
                        <td class="text-white justify-center h-full">
                            <div class="flex items-center gap-1">
                                <button class="bg-orange-400 p-2 rounded-lg h-fit" @click="toggleModal(x, 'Edit')">
                                    <fa icon="fas fa-edit" fixed-width></fa>
                                </button>

                                <button @click="hapusDosen(x)" class="bg-red-600 p-2 rounded-lg h-fit">
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
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-10 *:text-sm *:tracking-wide" v-if="!dataDosen">
                    <td colspan="8" class="text-center">
                        <p class="pb-5">Harap menunggu...</p>
                        <fa icon="fas fa-spinner" spin class="text-3xl"></fa>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="items-center justify-center w-screen h-screen bg-[#000000AA] z-50 absolute top-0 left-0 flex" v-if="isModalOn">
        <div class="flex flex-col bg-white px-5 py-7 rounded-xl gap-4 w-1/3 justify-center" v-if="modalMode == 'Add'"">
            <div class="flex w-full items-center justify-between pb-6">
                <p class="text-2xl font-medium text-indigo">Tambah Dosen</p>

                <fa @click="toggleModal(0, 'Add')" icon="fas fa-times" class="text-2xl" fixed-width></fa>
            </div>

            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center w-full justify-center gap-3">
                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="nama" placeholder="Masukkan nama dosen">
                    </div>
                    
                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-credit-card" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="nidn" placeholder="Masukkan NIDN">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-id-card" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="jabatan" placeholder="Masukkan Jabatan">
                    </div>

                    <div class="flex p-4 bg-indigo rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-school" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="prodi">
                            <option selected hidden value="0">Pilih prodi</option>
                            <option v-for="x in dataProdi" :value="x.id_prodi">{{ x.nm_prodi }}</option>
                        </select>
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-envelope" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="email" placeholder="Masukkan email">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-lock" class="text-gray-500" fixed-width />
                        <input type="password" class="bg-transparent outline-none w-full" v-model="password" placeholder="Masukkan password">
                    </div>

                    <button @click="tambahDosen()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-indigo text-white rounded-lg">
                        <fa icon="fas fa-plus"></fa>
                        Tambahkan
                    </button>
                </div>
            </div>
        </div>

        <div class="flex flex-col bg-white px-5 py-7 rounded-xl gap-4 w-1/3 justify-center" v-if="modalMode == 'Edit'">
            <div class="flex w-full items-center justify-between pb-6">
                <p class="text-2xl font-medium text-indigo">Edit Dosen</p>

                <fa @click="toggleModal(0, 'Edit')" icon="fas fa-times" class="text-2xl" fixed-width></fa>
            </div>

            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center w-full justify-center gap-3">
                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="nama" placeholder="Masukkan nama dosen">
                    </div>
                    
                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-credit-card" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="nidn" placeholder="Masukkan NIDN">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-id-card" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="jabatan" placeholder="Masukkan Jabatan">
                    </div>

                    <div class="flex p-4 bg-indigo rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-school" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="prodi">
                            <option selected hidden value="0">Pilih prodi</option>
                            <option v-for="x in dataProdi" :value="x.id_prodi">{{ x.nm_prodi }}</option>
                        </select>
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-envelope" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="email" placeholder="Masukkan email">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-lock" class="text-gray-500" fixed-width />
                        <input type="password" class="bg-transparent outline-none w-full" v-model="password" placeholder="Masukkan password">
                    </div>

                    <button @click="updateDosen()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-indigo text-white rounded-lg">
                        <fa icon="fas fa-floppy-disk"></fa>
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>