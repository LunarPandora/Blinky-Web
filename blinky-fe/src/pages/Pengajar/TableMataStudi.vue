<script setup>
    import { ref, onMounted, onUnmounted, watch } from 'vue'
    import { useRouter } from 'vue-router'

    import apiClient from '@/services/api'
    import DayFormatter from '@/services/day.js'
    import { useSessionStore } from '@/stores/session';

    const router = useRouter()
    const sessionStore = useSessionStore()

    const dataKelas = ref()
    const dataJadwal = ref()
    const isLoaded = ref(false)

    const kelas = ref(0)
    const hari = ref(0)
    const search = ref('')

    onMounted(() => {
        fetchInitData()
        fetchJadwal()
    })

    function loadData(el){
        setTimeout(2000)
        isLoaded.value = true;
    }

    async function fetchInitData(){
        dataKelas.value = []

        await apiClient.get('kelas').then(resp => {
            dataKelas.value = resp.data
        })
    }

    async function fetchJadwal() {
        dataJadwal.value = undefined
        isLoaded.value = false

        await apiClient.get('jadwal', {
            params: {
                id: sessionStore.session.id,
                hari: hari.value,
                id_kelas: kelas.value,
                role: sessionStore.session.role,
                search: search.value
            }
        })
        .then(resp => {
            dataJadwal.value = resp.data; // Update the data
            loadData()
        })
        .catch(err => {
            console.error("Error fetching jadwal:", err); // Handle any errors
        });
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

    watch(search, async(x, y) => {
        if(x != y){
            fetchJadwal()
        }
    })

    function openTanggal(x){
        router.push(`/dashboard/pengajar/mata_studi/presensi/${x.id_jadwal}`)
    }
</script>

<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-darkbrown font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Mata Studi
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200 bg-softcream">
        <div class="flex p-2 bg-cream rounded-lg items-center gap-3 w-[30%] text-sm leading-relaxed tracking-wide">
            <fa icon="fas fa-search" class="text-darkbrown"></fa>
            <input class="bg-transparent border-0 outline-none w-full placeholder:text-darkbrown" type="text" placeholder="Cari nama mata studi..." v-model="search">
        </div>

        <div class="flex items-center justify-end gap-3">
            <div class="flex p-2 bg-darkbrown rounded-lg items-center gap-2 max-w-[50%] text-sm">
                <fa icon="fas fa-door-closed" class="text-white"></fa>
                <select class="bg-transparent text-white outline-none *:bg-softcream *:text-black w-full" v-model="kelas">
                    <option selected value="0">Semua kelas</option>
                    <option v-for="x in dataKelas" :value="x.id_kelas">{{ x.nm_kelas }}</option>
                </select>
            </div>

            <div class="flex p-2 bg-darkbrown rounded-lg items-center gap-2 text-sm">
                <fa icon="fas fa-book" class="text-white"></fa>
                <select class="bg-transparent text-white outline-none *:bg-softcream *:text-black w-full" v-model="hari">
                    <option selected value="0">Semua hari</option>
                    <option v-for="x in 6" :value="x">{{ new DayFormatter(x).convertToDayName() }}</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-3 gap-3 w-full h-fit p-5 overflow-y-scroll scrollbar">
        <TransitionGroup name="slide" mode="out-in">
            <div @click="openTanggal(x)" v-for="x in dataJadwal" class="bg-darkbrown p-4 rounded-xl text-white flex flex-col gap-2 h-fit" v-if="isLoaded">
                <p class="text-lg font-medium">{{ x.mata_studi.nm_mata_studi }}</p>
                <div class="flex w-full items-center justify-between">
                    <p class="text-md">{{ x.kelas.nm_kelas }} - {{ new DayFormatter(x.hari).convertToDayName() }}</p>

                    <p>
                        <fa icon="fas fa-clock"></fa>
                        {{ x.jam_mulai }} - {{ x.jam_selesai }}
                    </p>
                </div>
            </div>
        </TransitionGroup>
    </div>
    
    <TransitionGroup name="slide" mode="out-in" @after-leave="loadData()">
        <div class="text-darkbrown flex flex-col w-full items-center justify-center" v-if="!dataJadwal">
            <fa icon="fas fa-spinner" spin class="text-3xl"></fa>
            <p class="pt-3">Harap menunggu...</p>
        </div>

        <div class="text-darkbrown flex flex-col w-full items-center justify-center" v-if="dataJadwal != undefined && dataJadwal.length < 1">
            <fa icon="fas fa-face-sad-cry" bounce class="text-3xl"></fa>
            <p class="pt-3">Tidak ada data kelas!</p>
        </div>
    </TransitionGroup>
</template>