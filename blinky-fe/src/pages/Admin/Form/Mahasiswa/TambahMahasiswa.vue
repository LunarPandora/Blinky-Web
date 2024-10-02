<script setup>
    import apiClient from '@/services/api'
    import {ref, onMounted} from 'vue'

    const dataKelas = ref()
    const dataProdi = ref()

    const queryConfirm = ref(false)
    const queryResult = ref('')

    const nim = ref('')
    const nama = ref('')
    const angkatan = ref('')
    const pw = ref('')

    function submit(){
        apiClient.get('/api/mahasiswa/add', {
            params: {
                nim: nim.value,
                nama: nama.value,
                kelas: document.getElementById('kelas').value,
                prodi: document.getElementById('prodi').value,
                angkatan: angkatan.value,
                pw: pw.value,
            }
        }).then(resp => {
            queryResult.value = resp.data
            queryConfirm.value = true
        })
    }

    onMounted(() => {
        apiClient.get('/api/kelas').then(resp => {
            dataKelas.value = resp.data
        })

        apiClient.get('/api/prodi').then(resp => {
            dataProdi.value = resp.data
        })
    })
</script>   

<template>
    <div class="flex-col gap-10 w-full" :class="{'flex' : queryConfirm, 'hidden' : !queryConfirm}">
        <p class="font-semibold text-lg" v-if="queryResult == 'success'">Data berhasil ditambahkan!</p>
        <p class="font-semibold text-lg" v-if="queryResult == 'error'">Data gagal ditambahkan!</p>
    </div>
    <div class="flex-col gap-10 w-full" :class="{'flex' : !queryConfirm, 'hidden' : queryConfirm}">
        <div class="flex items-center w-full justify-center gap-5">
            <div class="w-1/2">
                <div class="flex relative">
                    <p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">NIM</p>
                    <div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-indigo" fixed-width />
                        <input type="text" v-model="nim" class="border-0 p-0 outline-none w-full" placeholder="Masukkan NIM">
                    </div>
                </div>
            </div>
            <div class="w-1/2">
                <div class="flex relative">
                    <p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">Nama Mahasiswa</p>
                    <div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-indigo" fixed-width />
                        <input type="text" v-model="nama" class="border-0 p-0 outline-none w-full" placeholder="Masukkan nama mahasiswa">
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center w-full justify-center gap-5">
            <div class="w-1/2">
                <div class="flex relative">
                    <p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">Program Studi</p>
                    <div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-indigo" fixed-width />
                        <select id="prodi" class="bg-transparent text-indigo outline-none *:bg-white *:text-black w-full">
                            <option v-for="x in dataProdi" :value="x.id_prodi">{{ x.nm_prodi }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="w-1/2">
                <div class="flex relative">
                    <p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">Kelas</p>
                    <div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-indigo" fixed-width />
                        <select id="kelas" class="bg-transparent text-indigo outline-none *:bg-white *:text-black w-full">
                            <option v-for="x in dataKelas" :value="x.id_kelas">{{ x.nm_kelas }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center w-full justify-center gap-5">
            <div class="w-1/2">
                <div class="flex relative">
                    <p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">Angkatan</p>
                    <div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-indigo" fixed-width />
                        <input type="text" v-model="angkatan" class="border-0 p-0 outline-none w-full" placeholder="Masukkan tahun angkatan">
                    </div>
                </div>
            </div>
            <div class="w-1/2">
                <div class="flex relative">
                    <p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">Password (Opsional)</p>
                    <div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-indigo" fixed-width />
                        <input type="password" v-model="pw" class="border-0 p-0 outline-none w-full" placeholder="Masukkan password baru mahasiswa">
                    </div>
                </div>
            </div>
        </div>

        <button class="w-full p-4 bg-indigo text-white rounded-xl text-xl font-semibold" @click="submit()">
            Tambah
        </button>
    </div>
</template>