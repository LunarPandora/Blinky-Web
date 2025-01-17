<script setup>
    import { ref, onMounted, onUnmounted, watch } from 'vue'
    import { useRoute } from 'vue-router'

    import DateConverter from '@/services/date'
    import apiClient from '@/services/api';

    import { useSessionStore } from '@/stores/session';

    const s = useSessionStore()

    const isModalOn = ref(false)
    const loadingResult = ref(false)
    const progress = ref('loading')

    const tempImage = ref('-')
    const tempFile = ref('-')

    const email = ref('')
    const pass = ref('')
    const telp = ref('')
    const alamat = ref('')
    const agama = ref('0')
    const gender = ref('0')

    async function updateProfile(){
        progress.value = 'loading'
        loadingResult.value = true

        let form = new FormData()

        form.append('id', s.session.id)
        form.append('email', email.value)
        form.append('password', pass.value)
        form.append('no_telp', telp.value)
        form.append('alamat', alamat.value)
        form.append('gender', gender.value)
        form.append('agama', agama.value)
        form.append('picture', tempFile.value)
        form.append('role', 'Dosen')

        await apiClient.post('users/update', form)
        .then(resp =>{
            setTimeout(() => {
                progress.value = resp.data

                apiClient.get('users', {
                    params: {
                        id: s.session.id
                    }
                })
                .then(resp => {
                    s.registerSession(resp.data)
                    s.authenticate()

                    setTimeout(() => {
                        toggleModal()
                        loadingResult.value = false
                    }, 2000)
                })
            }, 2000)
        })
        .catch(er => {
            setTimeout(() => {
                progress.value = 'Failed!'
                setTimeout(() => {
                    toggleModal()
                    loadingResult.value = false
                }, 2000)
            }, 2000)
        })
    }

    function getFile(el){
        if(el.target.files.length > 0){
            let file = el.target.files[0]

            tempImage.value = URL.createObjectURL(file)
            tempFile.value = file
        }
        else{
            if(tempImage.value != '-'){
                tempImage.value = URL.createObjectURL(tempFile.value)
            }
        }
    }

    function toggleModal(val){
        isModalOn.value = !isModalOn.value

        if(isModalOn.value){
            email.value = s.session.email
            telp.value = s.session.pengajar.no_telp
            alamat.value = s.session.pengajar.alamat
            agama.value = s.session.pengajar.agama
            gender.value = s.session.pengajar.gender

            if(s.session.user_pic != '-'){
                tempImage.value = 'http://localhost:8000/storage/images/' + s.session.user_pic
            }
            else{
                tempImage.value = '-'
            }
        }
        else{
            email.value = ''
            pass.value = ''
            telp.value = ''
            alamat.value = ''
            agama.value = '0'
            gender.value = '0'
            tempImage.value = '-'
        }
        // temp_mhs.value = val

        // ket.value = val.keterangan

        // fetchData()
    }
</script>
<template>
    <div class="flex items-center justify-between sticky top-0 right-0 h-fit w-full p-5 border-b-[2px] border-b-gray-200">
        <div>
            <h1 class="text-darkbrown font-medium text-lg">
            Dashboard
                <fa icon="fas fa-chevron-right" fixed-width class="text-sm"></fa>
                Profil
            </h1>
        </div>
    </div>  
    <div class="flex flex-col items-center justify-center">
        <div name="gambar_bg" class="flex w-full">
            <img src="@/assets/profile-bg.jpg" class="h-56 w-full object-cover object-bottom">
        </div>
        <div class="flex flex-col w-full p-10 relative top-[-8rem] left-[0px] gap-4">
            <div class="flex w-1/2 items-end">
                <div class="w-44 h-44 overflow-hidden rounded-full flex items-center justify-center">
                    <img v-if="s.session.user_pic == '-'" src="@/assets/fp.png">
                    <img v-else :src="'http://localhost:8000/storage/images/' + s.session.user_pic">
                </div>
                
                <button class="rounded-full p-2 bg-leafgreen w-fit h-fit relative top-0 left-[-2.5rem]" @click="toggleModal(0)">
                    <fa icon="fas fa-edit" class="text-xl text-white" fixed-width></fa>
                </button>
            </div>

            <div class="flex flex-col gap-2">
                <p class="text-2xl font-medium text-darkbrown">{{ s.session.pengajar.nm_pengajar }}</p>
                <p class="text-md">Dosen - {{ s.session.pengajar.jabatan }}</p>
            </div>

            <div class="flex w-full gap-28 pt-3">
                <div class="flex flex-col gap-3 pt-6">
                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">Email</p>
                        <p class="text-black font-light text-md mb-4">{{ s.session.email }}</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">
                            {{ s.session.pengajar.tipe_pengajar == 'Dosen' ? 'NIDN' : 'NUPTK' }}
                        </p>
                        <p class="text-black font-light text-md mb-4">{{ s.session.pengajar.no_pengajar }}</p>
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">Prodi</p>
                        <p class="text-black font-light text-md mb-4">{{ s.session.pengajar.jurusan.nm_jurusan }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 pt-6">
                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">Jabatan</p>
                        <p class="text-black font-light text-md mb-4">{{ s.session.pengajar.jabatan }}</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">Status</p>
                        <p class="text-black font-light text-md mb-4">{{ s.session.pengajar.isActive }}</p>
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">Nomor Telepon</p>
                        <p class="text-black font-light text-md mb-4">{{ s.session.pengajar.no_telp }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 pt-6">
                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">Alamat</p>
                        <p class="text-black font-light text-md mb-4">{{ s.session.pengajar.alamat }}</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">Gender</p>
                        <p class="text-black font-light text-md mb-4">{{ s.session.pengajar.gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">Agama</p>
                        <p class="text-black font-light text-md mb-4">{{ s.session.pengajar.agama }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 pt-6"> 
                    <div class="flex flex-col gap-2">
                        <p class="text-darkbrown font-medium text-md">Password</p>
                        <p class="text-black font-light text-md mb-4">••••••••</p>
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <TransitionGroup name="fade" mode="out-in">
        <div class="items-center justify-center w-screen h-screen bg-[#000000AA] z-50 absolute top-0 left-0 flex" v-if="isModalOn">
            <Transition name="slideUp" mode="out-in">
                <div class="flex flex-col bg-cream px-5 py-7 rounded-xl gap-4 w-4/5 justify-center" v-if="!loadingResult">
                    <div class="flex w-full items-center justify-between pb-6">
                        <p class="text-2xl font-medium text-darkbrown">Edit Profil</p>

                        <fa @click="toggleModal(0)" icon="fas fa-times" class="text-2xl" fixed-width></fa>
                    </div>

                    <div class="flex gap-4 w-full h-full">
                        <div class="flex flex-col gap-8 w-1/2 h-full">
                            <div class="flex flex-col items-center w-full justify-center gap-3">
                                <div class="bg-softcream p-4 rounded-xl flex flex-col w-full gap-3">
                                    <div class="flex items-center gap-3">
                                        <fa icon="fas fa-envelope" class="text-darkbrown" fixed-width />
                                        <p class="text-darkbrown">Email</p>
                                    </div>

                                    <input type="text" class="text-darkbrown text-sm bg-transparent w-full outline-none" placeholder="Masukkan email..." v-model="email" />
                                </div>

                                <div class="bg-softcream p-4 rounded-xl flex flex-col w-full gap-3">
                                    <div class="flex items-center gap-3">
                                        <fa icon="fas fa-lock" class="text-darkbrown" fixed-width />
                                        <p class="text-darkbrown">Password</p>
                                    </div>

                                    <input type="password" class="text-darkbrown text-sm bg-transparent w-full outline-none" placeholder="Masukkan jika ingin mengubah password lama..." v-model="pass" />
                                </div>

                                <div class="bg-softcream p-4 rounded-xl flex flex-col w-full gap-3">
                                    <div class="flex items-center gap-3">
                                        <fa icon="fas fa-phone" class="text-darkbrown" fixed-width />
                                        <p class="text-darkbrown">Nomor Telepon</p>
                                    </div>

                                    <input type="text" class="text-darkbrown text-sm bg-transparent w-full outline-none" placeholder="Masukkan nomor telepon..." v-model="telp" />
                                </div>

                                <div class="bg-softcream p-4 rounded-xl flex flex-col justify-center w-full gap-3">
                                    <p class="flex gap-3 items-center">
                                        <fa icon="fas fa-house" class="text-darkbrown" fixed-width />
                                        <p class="text-darkbrown">Alamat rumah</p>
                                    </p>

                                    <textarea class="bg-transparent outline-none overflow-hidden text-sm h-24 resize-none" placeholder="Masukkan alamat rumah disini..." v-model="alamat"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-8 w-1/2 h-full">
                            <div class="flex flex-col items-center w-full justify-center gap-3 h-full">
                                <div class="bg-softcream p-4 rounded-xl flex flex-col w-full gap-3">
                                    <div class="flex items-center gap-3">
                                        <fa icon="fas fa-pray" class="text-darkbrown" fixed-width />
                                        <p class="text-darkbrown">Agama</p>
                                    </div>

                                    <select class="text-sm bg-transparent outline-none" v-model="agama">
                                        <option hidden readonly value="0">Pilih agama...</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>

                                <div class="bg-softcream p-4 rounded-xl flex flex-col w-full gap-3">
                                    <div class="flex items-center gap-3">
                                        <fa icon="fas fa-venus-mars" class="text-darkbrown" fixed-width />
                                        <p class="text-darkbrown">Gender</p>
                                    </div>

                                    <select class="text-sm bg-transparent outline-none" v-model="gender">
                                        <option hidden readonly value="0">Pilih agama...</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <div class="bg-softcream p-4 rounded-xl flex flex-col w-full gap-3">
                                    <div class="flex items-center gap-3">
                                        <fa icon="fas fa-image" class="text-darkbrown" fixed-width />
                                        <p class="text-darkbrown">Foto Profil</p>
                                    </div>

                                    <div class="w-36 h-36 overflow-hidden flex items-center justify-center rounded-full">
                                        <img v-if="tempImage == '-'" src="@/assets/fp.png">
                                        <img v-else :src="tempImage">
                                    </div>

                                    <div class="relative">
                                        <input type="file" class="pt-2 flex items-center 
                                            file:bg-blue-500 file:text-white file:border-0
                                            file:py-2 file:px-3 file:mr-3 file:rounded-lg
                                        " @change="getFile" multiple="false">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button @click="updateProfile()" class="w-full flex gap-2 items-center justify-center mt-1 p-3 bg-leafgreen text-white rounded-lg">
                        <fa icon="fas fa-floppy-disk"></fa>
                        Perbarui
                    </button>
                </div>
                <div v-else class="flex flex-col bg-cream px-5 py-7 rounded-xl w-1/4 items-center justify-center">
                    <Transition name="fade" mode="out-in">
                        <div class="flex flex-col gap-4" v-if="progress == 'loading'">
                            <fa icon="fas fa-spinner" spin class="text-3xl"></fa>
                            <p class="text-lg">Sedang memproses...</p>
                        </div>
                        <div class="flex flex-col gap-4" v-else-if="progress == 'Success!'">
                            <fa icon="fas fa-check" bounce class="text-3xl text-leafgreen"></fa>
                            <p class="text-lg">Profil berhasil di-update!</p>
                        </div>
                        <div class="flex flex-col gap-4" v-else-if="progress == 'Failed!'">
                            <fa icon="fas fa-times" bounce class="text-3xl text-softred"></fa>
                            <p class="text-lg">Profil gagal di-update!</p>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </div>
    </TransitionGroup>
</template>