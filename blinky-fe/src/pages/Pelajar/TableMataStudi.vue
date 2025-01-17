<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRouter } from 'vue-router'

    import apiClient from '@/services/api'
    import DayFormatter from '@/services/day.js'
    
    import { useSessionStore } from '@/stores/session';

    const router = useRouter()
    const sessionStore = useSessionStore()

    const dataPengajar = ref()
    const dataJadwal = ref()

    const kelas = ref(0)
    const hari = ref(0)

    onMounted(() => {
        fetchInitData()
        fetchJadwal()
    })

    async function fetchInitData(){
        await apiClient.get('pengajar/find', {
            params: {
                id_jurusan: sessionStore.session.pelajar.id_jurusan
            }
        }).then(resp => {
            dataPengajar.value = resp.data
        })
    }

    async function fetchJadwal() {
        // dataJadwal.value = []; // Reset the data

        await apiClient
            .get('jadwal', {
                params: {
                    // hari: hari.value,
                    // id: sessionStore.session.id, // Add the 'id' parameter here
                    id_kelas: sessionStore.session.pelajar.id_kelas,
                    role: 'Pelajar'
                }
            })
            .then(resp => {
                dataJadwal.value = resp.data; // Update the data
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

    function openTanggal(id){
        router.push(`/dashboard/pelajar/presensi/${id}`)
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
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-darkbrown font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Presensi
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
                    <option selected value="0">Semua pengajar</option>
                    <option v-for="x in dataPengajar" :value="x.id_pengajar">{{ x.nm_pengajar }}</option>
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
    <div class="grid grid-cols-3 gap-3 w-full h-full p-5 overflow-y-scroll scrollbar">
        <div @click="openTanggal(x.id_jadwal)" v-for="x in dataJadwal" class="bg-darkbrown p-4 rounded-xl text-white flex flex-col gap-2 h-fit">
            <p class="text-lg font-medium">{{ x.mata_studi.nm_mata_studi }}</p>
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