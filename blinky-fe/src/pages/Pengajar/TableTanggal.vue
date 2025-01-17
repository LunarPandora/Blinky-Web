<script setup>
    import { ref, onMounted, watch, nextTick } from 'vue'
    import { useRoute, useRouter } from 'vue-router'
    
    import DateConverter from '@/services/date'
    import apiClient from '@/services/api'

    const route = useRoute()
    const router = useRouter()

    const jlh_pelajar = ref(0)
    const isLoaded = ref(false)
    
    const jadwal = ref()
    const listPertemuan = ref()

    onMounted(() => {
        fetchData()
    })

    function loadData(el){
        isLoaded.value = true;
    }

    async function fetchData(){
        await apiClient.get('jadwal/find', {
            params: {
                id_jadwal: route.params.id_jadwal
            }
        })
        .then(resp => {
            jadwal.value = resp.data
            jlh_pelajar.value = jadwal.value.kelas.pelajar.length
        })

        await apiClient.get('pertemuan', {
            params: {
                id_jadwal: route.params.id_jadwal
            }
        })
        .then(resp => {
            listPertemuan.value = resp.data
        })
    }

    function openAbsensi(id, idx){
        router.push(`/dashboard/pengajar/mata_studi/presensi/${route.params.id_jadwal}/${id}/${idx}`)
    }
</script>
<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-darkbrown font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Mata Kuliah
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                <span v-if="jadwal">{{ jadwal.mata_studi.nm_mata_studi }} - {{ jadwal.kelas.nm_kelas }}</span>
            </h1>
        </div>
    </div>      
    
    <TransitionGroup name="fade" mode="out-in" @after-leave="loadData()">
        <div class="text-darkbrown flex flex-col h-full w-full items-center justify-center" v-if="!listPertemuan">
            <fa icon="fas fa-spinner" spin class="text-3xl"></fa>
            <p class="pt-3">Harap menunggu...</p>
        </div>
    </TransitionGroup>

    <div class="grid grid-cols-2 gap-3 w-full h-full p-5 overflow-y-scroll scrollbar">
        <TransitionGroup name="fade" mode="out-in">
            <div @click="openAbsensi(x.id_pertemuan, index + 1)" v-for="(x, index) in listPertemuan" class="bg-darkbrown p-4 rounded-xl text-white flex flex-col gap-2 h-fit" v-if="isLoaded">
                <div class="flex w-full items-center justify-between">
                    <div>
                        <p class="text-lg font-medium">Pertemuan ke-{{ index + 1 }}</p>
                        <p class="text-sm">Tanggal: {{ new DateConverter(x.tanggal_pertemuan).format(false) }}</p>
                    </div>
    
                    <p class="flex gap-4 items-center">
                        <div>
                            <fa icon="fas fa-check"></fa>
                            {{ x.presensi.length }}
                        </div>
    
                        <div>
                            <fa icon="fas fa-multiply"></fa>
                            {{ jlh_pelajar - x.presensi.length }}
                        </div>
                    </p>
                </div>
            </div>
        </TransitionGroup>
    </div>

</template>