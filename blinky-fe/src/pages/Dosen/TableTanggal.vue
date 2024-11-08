<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRoute, useRouter } from 'vue-router'

    import apiClient from '@/services/api'

    const route = useRoute()
    const router = useRouter()
    
    const jadwal = ref()
    const listPertemuan = ref()

    onMounted(() => {
        fetchData()
    })

    async function fetchData(){
        await apiClient.get('jadwal/find', {
            params: {
                id_jadwal: route.params.id_jadwal
            }
        })
        .then(resp => {
            jadwal.value = resp.data[0]
        })

        await apiClient.get('absensi/list_pertemuan', {
            params: {
                id_jadwal: route.params.id_jadwal
            }
        })
        .then(resp => {
            listPertemuan.value = resp.data
        })
    }

    function openAbsensi(id){
        router.push(`/dashboard/dosen/absensi/${route.params.id_jadwal}/${id}`)
    }
</script>
<template>
    <div class="flex items-center justify-between bg-keppel sticky top-0 right-0 h-fit w-full p-5 border-b-[3px] border-b-[#141140]">
        <div>
            <h1 class="text-white font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Mata Kuliah
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                <span v-if="jadwal">{{ jadwal.matkul.nm_matkul }} - {{ jadwal.kelas.nm_kelas }}</span>
            </h1>
        </div>
    </div>      
    <div class="grid grid-cols-2 gap-3 w-full h-full p-5 overflow-y-scroll scrollbar">
        <div @click="openAbsensi(x.pertemuan)" v-for="x in listPertemuan" class="bg-darkslate p-4 rounded-xl text-white flex flex-col gap-2 h-fit">
            <div class="flex w-full items-center justify-between">
                <p class="text-lg font-semibold">Pertemuan ke-{{ x.pertemuan }}</p>

                <p class="flex gap-2 items-center">
                    <fa icon="fas fa-users"></fa>
                    {{ x.total }}
                </p>
            </div>
        </div>
    </div>
</template>