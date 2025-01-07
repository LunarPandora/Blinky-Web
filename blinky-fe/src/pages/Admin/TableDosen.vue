<script setup>
    import { ref, onMounted, watch } from 'vue'
    import { useRoute } from 'vue-router'

    import DateConverter from '@/services/date'
    import apiClient from '@/services/api';

    const dataDosen = ref([])
    const dataProdi = ref()
    const dataUser = ref()
    const temp_data = ref()

    const nama = ref()
    const prodi = ref("0")
    const jabatan = ref()
    const nidn = ref()
    const users = ref()
    const password = ref()
    const telp = ref('')
    const alamat = ref('')
    const agama = ref('')
    const gender = ref('')
    const isActive = ref('')

    const isModalOn = ref(false)
    const modalMode = ref('Add')

    async function fetchData(){
        await apiClient.get('dosen')
        .then(resp => {
            dataDosen.value = []
            resp.data.map((d) => {
                dataDosen.value.push({
                    id_dosen: d.id_dosen,
                    nm_dosen: d.nm_dosen,
                    nidn: d.nidn,
                    jabatan: d.jabatan,
                    prodi: d.prodi.nm_prodi,
                    email: d.acc[0].email,
                    created_at: d.created_at,
                    updated_at: d.updated_at
                })
            })
        })

        await apiClient.get('prodi')
        .then(resp => {
        console.log(resp)
            dataProdi.value = resp.data
        })

        await apiClient.get('users')
        .then(resp => {
            dataUser.value = resp.data
        })
    }

    async function resetInput(){
        prodi.value = ''
        nama.value = ''
        jabatan.value = ''
        nidn.value = ''
        users.value = ''
        password.value = ''
        telp.value = ''
        alamat.value = ''
        agama.value = ''
        gender.value = ''
        isActive.value = ''
    }

    async function tambahDosen(){
        await apiClient.get('dosen/add', {
            params: {
                'id_prodi': prodi.value,
                'nm_dosen': nama.value,
                'jabatan': jabatan.value,
                'nidn': nidn.value,
                'users': users.value,
                'password': password.value,
                'no_telp' : telp.value,
                'alamat' : alamat.value,
                'agama' : agama.value,
                'gender' : gender.value,
                'isActive' : isActive.value,
            }
        })
        .then(resp => {
            if(resp.data == "Success!"){
                alert('Data dosen berhasil didaftarkan!')
            }
            else{
                alert('Data dosen gagal didaftarkan!')
            }

            resetInput()
            toggleModal(0, 'Add')
        })
    }

    async function updateDosen(){
        await apiClient.get('dosen/update', {
            params: {
                'id_dosen' : temp_data.value.id_dosen,
                'id_prodi' : prodi.value,
                'nm_dosen' : nama.value,
                'jabatan': jabatan.value,
                'nidn': nidn.value,
                'users': users.value,
                'password': password.value,
                'no_telp' : telp.value,
                'alamat' : alamat.value,
                'agama' : agama.value,
                'gender' : gender.value,
                'isActive' : isActive.value,
            }
        })
        .then(resp => {
            console.log(resp.data)

            toggleModal(0, 'Edit')
        })
    }

    async function hapusDosen(){
        await apiClient.get('dosen/delete', {
            params: {
                'id_dosen': temp_data.value.id_dosen,
            }
        })
        .then(resp => {
            if(resp.data == "Success!"){
                alert('Data dosen berhasil dihapus!')
                fetchData();
            }
            else{
                alert('Data dosen gagal dihapus!')
            }

            toggleModal(0, 'Delete')
        })
    }

    function toggleModal(val, mode){
        isModalOn.value = !isModalOn.value
        modalMode.value = mode

        temp_data.value = val

        if(mode == 'Edit'){
            prodi.value = val.id_prodi
            nama.value = val.nm_dosen
            jabatan.value = val.jabatan
            nidn.value = val.nidn
            users.value = val.id
            password.value = val.password
            telp.value = val.telp
            alamat.value = val.alamat
            agama.value = val.agama
            gender.value = val.agama
            isActive.value = val.isActive
        }
        else{
            resetInput()
        }

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
                Dosen
            </h1>
        </div>
    </div>  
    <div class="flex items-center justify-between gap-3 px-5 py-3 border-b-[2px] border-b-gray-200">
        <div class="flex p-2 bg-gray-200 rounded-lg items-center gap-3 w-[30%] leading-relaxed tracking-wide text-sm">
            <fa icon="fas fa-search" class="text-gray-500"></fa>
            <input class="bg-transparent border-0 outline-none w-full" type="text" placeholder="Cari nama dosen...">
        </div>

        <div class="flex items-center justify-end gap-5">
            <button @click="toggleModal(0, 'Add')" class="flex gap-2 items-center p-2 leading-relaxed tracking-wide text-sm bg-blue-500 text-white rounded-lg">
                <fa icon="fas fa-plus"></fa>
                Tambahkan dosen baru
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
                <tr class="*:p-3 *:text-left *:font-medium sticky top-0 bg-darkbrown text-white">
                    <th width="20%" class="rounded-tl-lg">Nama</th>
                    <th width="10%">NIDN</th>
                    <th width="10%">Jabatan</th>
                    <th width="10%">Prodi</th>
                    <th width="10%">Email</th>
                    <th width="10%">Waktu Pendaftaran</th>
                    <th width="10%">Terakhir kali diedit</th>
                    <th width="5%" class="rounded-tr-lg">Action</th>
                </tr>
            </thead>
            <tbody>
                <TransitionGroup name="slideUp" mode="out-in">
                    <tr class="bg-white odd:bg-[#f5f1e4] border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide" v-for="(x, index) in dataDosen" :key="index" v-if="dataDosen">
                        <td>{{ x.nm_dosen }}</td>
                        <td>{{ x.nidn }}</td>
                        <td>{{ x.jabatan }}</td>
                        <td>{{ x.prodi }}</td>
                        <td>{{ x.email }}</td>
                        <td>{{ new DateConverter(x.created_at).format() }}</td>
                        <td>{{ new DateConverter(x.updated_at).format() }}</td>
                        <td class="text-white justify-center h-full">
                            <div class="flex items-center gap-1">
                                <button class="bg-orange-400 p-2 rounded-lg h-fit" @click="toggleModal(x, 'Edit')">
                                    <fa icon="fas fa-edit" fixed-width></fa>
                                </button>

                                <button class="bg-red-600 p-2 rounded-lg h-fit" @click="toggleModal(x, 'Delete')">
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
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-10 *:text-sm *:tracking-wide" v-if="!dataDosen">
                    <td colspan="8" class="text-center">
                        <p class="pb-5">Harap menunggu...</p>
                        <fa icon="fas fa-spinner" spin class="text-3xl"></fa>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="items-center justify-center w-screen h-screen bg-[#000000AA] z-50 absolute top-0 left-0 flex" v-if="isModalOn">
        <div class="flex flex-col bg-cream px-5 py-7 rounded-xl gap-4 w-4/5 justify-center" v-if="modalMode == 'Add'">
            <div class="flex w-full items-center justify-between pb-6">
                <p class="text-2xl font-medium text-darkbrown">Tambah Dosen</p>

                <fa @click="toggleModal(0, 'Add')" icon="fas fa-times" class="text-2xl" fixed-width></fa>
            </div>

            <div class="flex gap-4 w-full h-full">
                <div class="flex flex-col gap-8 w-1/2 h-full">
                    <div class="flex flex-col items-center w-full justify-center gap-3">
                        <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                            <fa icon="fas fa-user" class="text-gray-500" fixed-width />
                            <input type="text" class="bg-transparent outline-none w-full" v-model="nama" placeholder="Masukkan nama dosen">
                        </div>

                        <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                            <fa icon="fas fa-credit-card" class="text-gray-500" fixed-width />
                            <input type="text" class="bg-transparent outline-none w-full" v-model="nidn" placeholder="Masukkan NIDN">
                        </div>

                        <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                            <fa icon="fas fa-id-card" class="text-gray-500" fixed-width />
                            <input type="text" class="bg-transparent outline-none w-full" v-model="jabatan" placeholder="Masukkan Jabatan">
                        </div>

                        <div class="flex p-4 bg-softbrown rounded-lg items-center gap-3 w-full">
                            <fa icon="fas fa-school" class="text-white"></fa>
                            <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="prodi">
                                <option selected hidden value="0">Pilih prodi</option>
                                <option v-for="x in dataProdi" :value="x.id_prodi">{{ x.nm_prodi }}</option>
                            </select>
                        </div>

                        <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                            <fa icon="fas fa-envelope" class="text-gray-500" fixed-width />
                            <input type="text" class="bg-transparent outline-none w-full" v-model="email" placeholder="Masukkan email">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-8 w-1/2 h-full">
                    <div class="flex flex-col items-center w-full justify-center gap-3 h-full">
                        <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                            <fa icon="fas fa-lock" class="text-gray-500" fixed-width />
                            <input type="password" class="bg-transparent outline-none w-full" v-model="password" placeholder="Masukkan password">
                        </div>

                        <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                            <fa icon="fas fa-phone" class="text-gray-500" fixed-width />
                            <input type="telp" class="bg-transparent outline-none w-full" v-model="telp" placeholder="Masukkan nomor telepon">
                        </div>

                        <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                            <fa icon="fas fa-house" class="text-gray-500" fixed-width />
                            <input type="alamat" class="bg-transparent outline-none w-full" v-model="alamat" placeholder="Masukkan alamat">
                        </div>

                        <div class="flex p-4 bg-softbrown rounded-lg items-center gap-3 w-full">
                            <fa icon="fas fa-pray" class="text-white"></fa>
                            <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="agama">
                                <option hidden readonly value="0">Pilih agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>

                        <div class="flex p-4 bg-softbrown rounded-lg items-center gap-3 w-full">
                            <fa icon="fas fa-venus-mars" class="text-white"></fa>
                            <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="gender">
                                <option hidden readonly value="0">Pilih agama...</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="flex p-4 bg-softbrown rounded-lg items-center gap-3 w-full">
                            <fa icon="fas fa-check" class="text-white"></fa>
                            <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="isActive">
                                <option hidden readonly value="0">Status...</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak aktif">Tidak aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <button @click="tambahDosen()" class="w-full flex gap-2 items-center justify-center mt-1 p-3 bg-leafgreen text-white rounded-lg">
                <fa icon="fas fa-floppy-disk"></fa>
                Tambahkan
            </button>
        </div>

        <div class="flex flex-col bg-cream px-5 py-7 rounded-xl gap-4 w-1/3 justify-center" v-if="modalMode == 'Edit'">
            <div class="flex w-full items-center justify-between pb-6">
                <p class="text-2xl font-medium text-indigo">Edit Dosen</p>

                <fa @click="toggleModal(0, 'Edit')" icon="fas fa-times" class="text-2xl" fixed-width></fa>
            </div>

            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center w-full justify-center gap-3">
                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-user" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="nama" placeholder="Masukkan nama dosen">
                    </div>
                    
                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-credit-card" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="nidn" placeholder="Masukkan NIDN">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-id-card" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="jabatan" placeholder="Masukkan Jabatan">
                    </div>

                    <div class="flex p-4 bg-softbrown rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-school" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="prodi">
                            <option selected hidden value="0">Pilih prodi</option>
                            <option v-for="x in dataProdi" :value="x.id_prodi">{{ x.nm_prodi }}</option>
                        </select>
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-envelope" class="text-gray-500" fixed-width />
                        <input type="text" class="bg-transparent outline-none w-full" v-model="email" placeholder="Masukkan email">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-lock" class="text-gray-500" fixed-width />
                        <input type="password" class="bg-transparent outline-none w-full" v-model="password" placeholder="Masukkan password">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-lock" class="text-gray-500" fixed-width />
                        <input type="telp" class="bg-transparent outline-none w-full" v-model="telp" placeholder="Masukkan nomor telepon">
                    </div>

                    <div class="bg-gray-200 p-4 rounded-xl flex items-center w-full gap-3">
                        <fa icon="fas fa-lock" class="text-gray-500" fixed-width />
                        <input type="alamat" class="bg-transparent outline-none w-full" v-model="alamat" placeholder="Masukkan alamat">
                    </div>

                    <div class="flex p-4 bg-softbrown rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-school" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="agama">
                            <option selected hidden value="0">Pilih agama</option>
                            <option v-for="x in dataDosen" :value="x.id_dosen">{{ x.agama }}</option>
                        </select>
                    </div>

                    <div class="flex p-4 bg-softbrown rounded-lg items-center gap-3 w-full">
                        <fa icon="fas fa-school" class="text-white"></fa>
                        <select class="bg-transparent text-white outline-none *:bg-white *:text-black w-full" v-model="gender">
                            <option selected hidden value="0">Pilih gender</option>
                            <option v-for="x in dataDosen" :value="x.id_dosen">{{ x.gender }}</option>
                        </select>
                    </div>

                    <button @click="updateDosen()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-darkbrown text-white rounded-lg">
                        <fa icon="fas fa-floppy-disk"></fa>
                        Update
                    </button>
                </div>
            </div>
        </div>
        <div class="flex flex-col bg-cream px-5 py-7 rounded-xl w-1/3 justify-center" v-if="modalMode == 'Delete'">
            <div class="flex w-full items-center justify-between pb-6">
                <p class="text-2xl font-medium text-darkbrown">Hapus Dosen</p>
            </div>

            <div class="flex flex-col gap-2">
                <p class="text-l text-darkbrown">Apakah anda yakin ingin menghapus data ini?</p>
                <div class="flex flex-row items-center w-full justify-center gap-3">
                    <button @click="toggleModal(0, 'Delete')" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-transparent outline outline-darkbrown [outline-offset:-2.5px] text-darkbrown rounded-lg">
                        Tidak
                    </button>

                    <button @click="hapusDosen()" class="w-full flex gap-2 items-center justify-center mt-5 p-3 bg-softred text-white rounded-lg">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>