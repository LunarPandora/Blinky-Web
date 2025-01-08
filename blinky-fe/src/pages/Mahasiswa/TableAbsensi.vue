<script setup>
    import { ref, onMounted } from 'vue';
    import { useRoute } from 'vue-router';

    import DateConverter from '@/services/date';
    import apiClient from '@/services/api';

    import { useSessionStore } from '@/stores/session';

    const route = useRoute();
    const sessionStore = useSessionStore()
    const currentDate = ref(Date.now())

    const dataAbsensi = ref([]);
    const dataStatus = ref([]);
    const jadwal = ref();

    const mahasiswa = ref(0);
    const temp_id = ref(null);
    const modeModal = ref('');
    const date = ref(new Date());
    const time = ref(new Date());

    const isModalOn = ref(false)
    const loadingResult = ref(false)
    const progress = ref('loading')

    onMounted(() => {
        fetchData();
    });

    async function clockIn(x){
        isModalOn.value = true
        progress.value = 'loading'
        loadingResult.value = true

        await apiClient.post('absensi/add', {
            params: {
                id_kelas: jadwal.value.kelas.id_kelas,
                id_mhswa: sessionStore.session.mhswa.id_mhswa,
                id_pertemuan: x.id_pertemuan,
                kode_status_absensi: 1
            }
        })
        .then(resp =>{
            setTimeout(() => {
                progress.value = resp.data
                setTimeout(() => {
                    isModalOn.value = false
                    loadingResult.value = false
                }, 2000)
            }, 2000)
        })
        .catch(er => {
            setTimeout(() => {
                progress.value = 'Failed!'
                setTimeout(() => {
                    isModalOn.value = false
                    loadingResult.value = false
                }, 2000)
            }, 2000)
        })
    }

    async function fetchData() {
        await apiClient.get('jadwal/find', {
            params: {
                id_jadwal: route.params.id_jadwal
            }
        })
        .then(resp => {
            jadwal.value = resp.data
        })

        await apiClient.get('pertemuan', {
            params: { 
                id_jadwal: route.params.id_jadwal
            },
        })
        .then(resp => {
            dataAbsensi.value = []

            resp.data.map((x, i) => {
                let kehadiran = false
                x.absensi.map((y) => {
                    if(y.id_mhswa == sessionStore.session.mhswa.id_mhswa){
                        kehadiran = y.status[0].status_absensi
                        return;
                    }
                })

                dataAbsensi.value.push(
                    {
                        'pertemuan': 'Pertemuan ke-' + (i + 1),
                        'tanggal': x.tanggal_pertemuan,
                        'absensi': x.updated_at,
                        'kehadiran': kehadiran,
                        'date_eligible_start': new Date(x.tanggal_pertemuan + 'T' + x.jadwal.jam_mulai),
                        'date_eligible_stop': new Date(x.tanggal_pertemuan + 'T' + x.jadwal.jam_selesai)
                    }
                )
            })
        });
    }
</script>

<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-darkbrown font-medium text-lg">
                Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Absensi
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                <span v-if="jadwal">{{ jadwal.matkul.nm_matkul }} - {{ jadwal.kelas.nm_kelas }}</span>
            </h1>
        </div>
    </div>  
    <div class="flex gap-16 items-center justify-start sticky top-0 right-0 h-fit w-full p-5 ">
        <div class="flex flex-col">
            <h4 class="text-darkbrown font-medium text-md">Mata Kuliah</h4>
            <h3>{{ jadwal ? jadwal.matkul.nm_matkul : '-' }}</h3>
        </div>
        <div class="flex flex-col">
            <h4 class="text-darkbrown font-medium text-md">Kelas</h4>
            <h3>{{ jadwal ? jadwal.kelas.nm_kelas : '-' }}</h3>
        </div>

        <div class="flex flex-col">
            <h4 class="text-darkbrown font-medium text-md">Jam Mulai</h4>
            <h3>{{ jadwal ? jadwal.jam_mulai : '-' }}</h3>
        </div>

        <div class="flex flex-col">
            <h4 class="text-darkbrown font-medium text-md">Jam Selesai</h4>
            <h3>{{ jadwal ? jadwal.jam_selesai : '-' }}</h3>
        </div>
    </div>

    <div class="flex flex-col w-full h-full overflow-y-scroll justify-between px-5 my-4 scrollbar">
        <table class="w-full">
            <thead>
                <tr class="*:p-3 *:text-left *:font-medium sticky top-0 bg-darkbrown text-white">
                    <th width="20%" class="rounded-tl-lg">Pertemuan</th>
                    <th width="25%">Tanggal</th>
                    <th width="25%">Absensi</th>
                    <th width="10%">Kehadiran</th>
                    <th width="20%" class="rounded-tr-lg">Action</th>
                </tr>
            </thead>
            <tbody>
                <TransitionGroup name="slideUp" mode="out-in">
                    <tr class="bg-white odd:bg-[#f5f1e4] border-b-gray-200 text-black *:px-3 *:py-3 *:text-sm *:tracking-wide" v-for="(x, index) in dataAbsensi" :key="index" v-if="dataAbsensi.length > 0">
                        <td>{{ x.pertemuan }}</td>
                        <td>{{ new DateConverter(x.tanggal).format(false) }}</td>
                        <td>{{ x.kehadiran != false ? new DateConverter(x.absensi).format() : 'Belum diabsen' }}</td>
                        <td>
                            <p v-if="x.kehadiran == false">Belum diabsen</p>
                            <p v-else>{{ x.kehadiran }}</p>
                        </td>
                        <td class="flex gap-2 text-white items-center">
                            <div v-if="x.kehadiran == false">
                                <div class="flex gap-2" v-if="currentDate < x.date_eligible_start || currentDate > x.date_eligible_stop">
                                    <button class="flex p-2 bg-gray-400 rounded-lg items-center gap-2 h-fit" onclick="alert('Pengisian absensi sedang diluar jadwal! Harap coba saat tanggal dan waktu absensi sesuai!')">
                                        <fa icon="fas fa-check"></fa>
                                        Isi Kehadiran
                                    </button>
                                    <!-- <button class="flex p-2 bg-gray-400 rounded-lg items-center gap-2 h-fit" onclick="alert('Pengisian absensi sedang diluar jadwal! Harap coba saat tanggal dan waktu absensi sesuai!')">
                                        <fa icon="fas fa-times"></fa>
                                        Tidak Hadir
                                    </button> -->
                                </div>
                                <div class="flex gap-2" v-else>
                                    <button @click="clockIn(x)" class="flex p-2 bg-leafgreen rounded-lg items-center gap-2 h-fit">
                                        <fa icon="fas fa-check"></fa>
                                        Isi Kehadiran
                                    </button>
                                    <!-- <button class="flex p-2 bg-softred rounded-lg items-center gap-2 h-fit">
                                        <fa icon="fas fa-times"></fa>
                                        Tidak Hadir
                                    </button> -->
                                </div>
                            </div>

                            <button v-else class="flex p-2 bg-orange-400 rounded-lg items-center gap-2 h-fit">
                                <fa icon="fas fa-edit"></fa>
                                Keterangan
                            </button>
                        </td>
                    </tr>

                    
                    <!-- <tr class="odd:bg-[#f5f1e4] border-b-gray-200 text-darkbrown *:text-sm *:tracking-wide " v-else>
                        <td colspan="5">
                            <div class="flex flex-col items-center justify-center py-7">
                                <fa icon="fas fa-face-sad-cry" bounce class="text-3xl"></fa>
                                <p class="pt-3">Tidak ada data kelas!</p>
                            </div>
                        </td>
                    </tr> -->
                </TransitionGroup>
                
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-10 *:text-sm *:tracking-wide" v-if="!dataAbsensi">
                    <td colspan="5" class="text-center">
                        <p class="pb-5">Harap menunggu...</p>
                        <fa icon="fas fa-spinner" spin class="text-3xl"></fa>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <TransitionGroup name="fade" mode="out-in">
        <div class="items-center justify-center w-screen h-screen bg-[#000000AA] z-50 absolute top-0 left-0 flex" v-if="isModalOn">
            <Transition name="slideUp" mode="out-in">
                <div class="flex flex-col bg-cream px-5 py-7 rounded-xl w-1/4 items-center justify-center">
                    <Transition name="fade" mode="out-in">
                        <div class="flex flex-col gap-4" v-if="progress == 'loading'">
                            <fa icon="fas fa-spinner" spin class="text-3xl"></fa>
                            <p class="text-lg">Sedang memproses...</p>
                        </div>
                        <div class="flex flex-col gap-4" v-else-if="progress == 'Success!'">
                            <fa icon="fas fa-check" bounce class="text-3xl text-leafgreen"></fa>
                            <p class="text-lg">Absensi berhasil terisi!</p>
                        </div>
                        <div class="flex flex-col gap-4" v-else-if="progress == 'Failed!'">
                            <fa icon="fas fa-times" bounce class="text-3xl text-softred"></fa>
                            <p class="text-lg">Absensi gagal diisi!</p>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </div>
    </TransitionGroup>
</template>