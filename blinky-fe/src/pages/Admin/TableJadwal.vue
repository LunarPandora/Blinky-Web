<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRoute } from 'vue-router'

    import DateConverter from '@/services/date'
    import apiClient from '@/services/api';

    const dataJadwal = ref()
    const dataKelas = ref()
    const dataDosen = ref()
    const dataMatkul = ref()

    const kelas = ref("0")
    const dosen = ref("0")
    const matkul = ref("0")
    const hari = ref()
    const jam_mulai = ref()
    const jam_selesai = ref()
    const pertemuan = ref()

    const isModalOn = ref(false)

    async function fetchData(){
        await apiClient.get('jadwal')
        .then(resp => {
            dataJadwal.value = resp.data
        })

        await apiClient.get('kelas')
        .then(resp => {
            dataKelas.value = resp.data
        })

        await apiClient.get('dosen')
        .then(resp => {
            dataDosen.value = resp.data
        })

        await apiClient.get('matkul')
        .then(resp => {
            dataMatkul.value = resp.data
        })
    }

    async function tambahJadwal(){
        await apiClient.get('jadwal/add', {
            params: {
                'id_kelas': kelas.value,    
                'id_dosen': dosen.value,
                'id_matkul': matkul.value,
                'jam_mulai': jam_mulai.value,
                'jam_selesai': jam_selesai.value,
                'hari': hari.value,
                'pertemuan': pertemuan.value
            }
        })
        .then(resp => {
            if(resp.data == "Success!"){
                alert('Data jadwal berhasil didaftarkan!')
            }
            else{
                alert('Data jadwal gagal didaftarkan!')
            }

            toggleModal(0)
        })
    }

    function toggleModal(val){
        isModalOn.value = !isModalOn.value

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
                Jadwal
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200 bg-white">
        <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] text-sm leading-relaxed tracking-wide">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari jadwal...">
        </div>

        <div class="flex items-center justify-end gap-5">
            <button @click="toggleModal(0)" class="flex gap-2 items-center p-2 leading-relaxed tracking-wide text-sm bg-blue-500 text-white rounded-lg">
                <fa icon="fas fa-plus"></fa>
                Tambahkan jadwal baru
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
                    <th width="15%">Kelas</th>
                    <th width="15%">Matkul</th>
                    <th width="15%">Dosen</th>
                    <th width="15%">Hari</th>
                    <th width="15%">Jam Mulai</th>
                    <th width="15%">Jam Selesai</th>
                    <th width="15%">Pertemuan</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <TransitionGroup name="fade" mode="out-in">
                    <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide" v-for="(x, index) in dataJadwal" :key="index" v-if="dataJadwal">
                        <td>{{ x.kelas.nm_kelas }}</td>
                        <td>{{ x.matkul.nm_matkul }}</td>
                        <td>{{ x.dosen.nm_dosen }}</td>
                        <td>{{ x.hari }}</td>
                        <td>{{ x.jam_mulai }}</td>
                        <td>{{ x.jam_selesai }}</td>
                        <td>{{ x.pertemuan }}</td>
                        <td class="text-white justify-center h-full">
                            <div class="flex items-center gap-1">
                                <button class="bg-orange-400 p-2 rounded-lg h-fit">
                                    <fa icon="fas fa-edit" fixed-width></fa>
                                </button>

                                <button class="bg-red-600 p-2 rounded-lg h-fit">
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
    
    <div class="items-center justify-center w-screen h-screen bg-[#000000AA] z-50 absolute top-0 left-0 flex" v-if="isModalOn">
        <div class="flex flex-col bg-white px-5 py-7 rounded-xl gap-4 w-1/3 justify-center">
            <div class="flex w-full items-center justify-between pb-6">
                <p class="text-2xl font-medium text-indigo">Tambah Jadwal</p>

                <fa @click="toggleModal(0)" icon="fas fa-times" class="text-2xl" fixed-width></fa>
            </div>

            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center w-full justify-center gap-3">
                    <div class="flex p-4 bg-indigo rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-door-closed" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="kelas">
                            <option selected hidden value="0">Pilih kelas</option>
                            <option v-for="x in dataKelas" :value="x.id_kelas">{{ x.nm_kelas }}</option>
                        </select>
                    </div>

                    <div class="flex p-4 bg-indigo rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-book" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="matkul">
                            <option selected hidden value="0">Pilih matkul</option>
                            <option v-for="x in dataMatkul" :value="x.id_matkul">{{ x.nm_matkul }}</option>
                        </select>
                    </div>

                    <div class="flex p-4 bg-indigo rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-graduation-cap" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="dosen">
                            <option selected hidden value="0">Pilih dosen</option>
                            <option v-for="x in dataDosen" :value="x.id_dosen">{{ x.nm_dosen }}</option>
                        </select>
                    </div>

                    <div class="flex p-4 bg-indigo rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-calendar" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="hari">
                            <option selected hidden value="0">Pilih hari</option>
                            <option v-for="x in 7" :value="x">{{ x }}</option>
                        </select>
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-clock" class="text-gray-500" fixed-width />
                        <input type="time" class="bg-transparent outline-none w-full" v-model="jam_mulai" placeholder="Masukkan jam mulai">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-clock" class="text-gray-500" fixed-width />
                        <input type="time" class="bg-transparent outline-none w-full" v-model="jam_selesai" placeholder="Masukkan jam selesai">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-envelope" class="text-gray-500" fixed-width />
                        <input type="test" class="bg-transparent outline-none w-full" v-model="pertemuan" placeholder="Masukkan jumlah pertemuan">
                    </div>

                    <button @click="tambahJadwal()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-indigo text-white rounded-lg">
                        <fa icon="fas fa-plus"></fa>
                        Tambahkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>