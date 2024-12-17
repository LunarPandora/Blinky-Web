<script setup>
    import { ref, onMounted } from 'vue';
    import { useRoute } from 'vue-router';
    import DateConverter from '@/services/date'; // Pastikan ada utilitas ini
    import apiClient from '@/services/api'; // API client untuk melakukan request

    // Route parameters
    const route = useRoute();

    // State
    const dataAbsensi = ref([]);
    const dataStatus = ref([]);

    const mahasiswa = ref(0);
    const temp_id = ref(null);
    const isModalOn = ref(false);
    const modeModal = ref('');
    const date = ref(new Date());
    const time = ref(new Date());

    // Fetch data on mount
    onMounted(() => {
        fetchData();
    });

    // Fetch all necessary data
    async function fetchData() {
        try {
            // Fetch data absensi
            const absensiResponse = await apiClient.get('pertemuan/find', {
                params: { id_pertemuan: route.params.id_pertemuan },
            });
            dataAbsensi.value = absensiResponse.data.map(item => ({
                pertemuan: item.pertemuan, // Nomor pertemuan
                tanggal: item.tanggal_pertemuan, // Tanggal pertemuan
                status_absensi: item.kode_status_absensi, // Status absensi
            }));

            // Fetch status absensi
            const statusResponse = await apiClient.get('statusabsensi');
            dataStatus.value = statusResponse.data;
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }
</script>

<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-indigo font-medium text-lg">
                Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Absensi
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Pemrograman Web Lanjutan
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-start sticky top-0 right-0 h-fit w-full p-5 ">
        <div class="">
            <h4 class="text-indigo font-medium text-md">Mata Kuliah</h4>
            <h3>ST1020-Pemrograman Web Lanjutan</h3>
        </div>
        <div class="flex-col ml-20">
            <h4 class="text-indigo font-medium text-md">Periode</h4>
            <h3>2024/2025 Ganjil</h3>
        </div>
    </div>
    <div class="flex flex-col w-full h-full overflow-y-scroll justify-between px-5 my-4 scrollbar">
        <table class="w-full">
            <thead>
                <tr class="*:p-3 *:border-y-2 *:text-left *:font-medium sticky top-0 bg-indigo text-white *:text-center">
                    <th width="35%">Pertemuan</th>
                    <th width="35%">Tanggal</th>
                    <th width="30%">Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black :px-3:py-2 :text-sm:tracking-wide" v-for="(x, index) in dataAbsensi" :key="index">
                    <td>{{ x.pertemuan }}</td>
                    <td>{{ new DateConverter(x.tanggal).format() }}</td>
                    <td>
                        <select class="bg-transparent text-black outline-none w-full text-sm" :value="x.status_absensi" :id="'select-' + index" @change="updateStatus(x, index)">
                            <option v-for="y in dataStatus" :value="y.kode_status_absensi">{{ y.status_absensi }}</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>