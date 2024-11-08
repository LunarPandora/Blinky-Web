<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRouter } from 'vue-router'

    import apiClient from '@/services/api'
    import DayFormatter from '@/services/day.js'

    const router = useRouter()

    const dataKelas = ref()
    const dataJadwal = ref()

    const kelas = ref(0)
    const hari = ref(0)

    onMounted(() => {
        fetchInitData()
        fetchJadwal()
    })

    async function fetchInitData(){
        dataKelas.value = []

        await apiClient.get('kelas').then(resp => {
            dataKelas.value = resp.data
        })
    }

    async function fetchJadwal(){
        dataJadwal.value = []

        await apiClient.get('jadwal', {
            hari: hari.value,
            id_kelas: kelas.value
        })
        .then(resp => {
            dataJadwal.value = resp.data
        })
    }

    watch(kelas, async(x, y) => {
        if(x != y){
            fetchJadwal()
        }
    })

    watch(hari, async(x, y) => {
        if(x != y){
            fetchJadwal()
        }
    })

    function openTanggal(id){
        router.push(`/dashboard/dosen/absensi/${id}`)
    }

    // function toggleModal(btn, data){
    //     isModalOn.value = !isModalOn.value
    //     if(btn != 'Tambah'){
    //         selectedData.value = data
    //     }

    //     formType.value = btn
        
    //     if(!isModalOn.value){
    //         fetchData();
    //     }
    // }
</script>

<template>
    <div class="flex items-center justify-between bg-keppel sticky top-0 right-0 h-fit w-full p-5 border-b-[3px] border-b-[#141140]">
        <div>
            <h1 class="text-white font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Mata Kuliah
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 p-5 border-b-[3px] border-b-[#141140]">
        <div class="flex p-3 bg-darkslate rounded-lg items-center gap-3 w-[30%]">
            <fa icon="fas fa-search" class="text-white"></fa>
            <input class="bg-transparent border-0 outline-none w-full text-white" type="text" placeholder="Cari nama mata kuliah...">
        </div>

        <div class="flex items-center justify-end gap-5">
            <div class="flex p-3 bg-indigo rounded-lg items-center gap-2 max-w-[50%]">
                <fa icon="fas fa-door-closed" class="text-white"></fa>
                <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="kelas">
                    <option selected value="0">Semua kelas</option>
                    <option v-for="x in dataKelas" :value="x.id_kelas">{{ x.nm_kelas }}</option>
                </select>
            </div>

            <div class="flex p-3 bg-indigo rounded-lg items-center gap-2">
                <fa icon="fas fa-book" class="text-white"></fa>
                <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="hari">
                    <option selected value="0">Semua hari</option>
                    <option v-for="x in 6" :value="x">{{ new DayFormatter(x).convertToDayName() }}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-3 w-full h-full p-5 overflow-y-scroll scrollbar">
        <div @click="openTanggal(x.id_jadwal)" v-for="x in dataJadwal" class="bg-darkslate p-4 rounded-xl text-white flex flex-col gap-2 h-fit">
            <p class="text-lg font-semibold">{{ x.matkul.nm_matkul }}</p>
            <div class="flex w-full items-center justify-between">
                <p class="text-md">{{ x.kelas.nm_kelas }} - {{ new DayFormatter(x.hari).convertToDayName() }}</p>

                <p>
                    <fa icon="fas fa-clock"></fa>
                    {{ x.jam_mulai }} - {{ x.jam_selesai }}
                </p>
            </div>
        </div>
    </div>
</template>