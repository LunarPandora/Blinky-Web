<script setup>
    import apiClient from '@/services/api'
    import {ref, onMounted} from 'vue'

    const queryConfirm = ref(false)
    const queryResult = ref('')

    const props = defineProps(['selectedData'])

    const nim = ref(props.selectedData.id_mhswa)
    const nama = ref(props.selectedData.nm_mahasiswa)

    function submit(){
        apiClient.get('/api/mahasiswa/delete', {
            params: {
                nim: nim.value,
            }
        }).then(resp => {
            queryResult.value = resp.data
            queryConfirm.value = true
        })
    }

</script>

<template>
    <div class="flex-col gap-10 w-full" :class="{'flex' : queryConfirm, 'hidden' : !queryConfirm}">
        <p class="font-semibold text-lg" v-if="queryResult == 'success'">Data berhasil dihapus!</p>
        <p class="font-semibold text-lg" v-if="queryResult == 'error'">Data gagal dihapus!</p>
    </div>
    <div class="flex-col gap-10 w-full" :class="{'flex' : !queryConfirm, 'hidden' : queryConfirm}">
        <p class="text-lg">Apakah anda yakin ingin <span class="font-semibold">menghapus</span> data mahasiswa <span class="font-semibold">"{{ nama }} - {{ nim }}"</span> ?</p>

        <button class="w-full p-4 bg-red-500 text-white rounded-xl text-xl font-semibold" @click="submit()">
            Hapus
        </button>
    </div>
</template>