<script setup>
	import { ref } from 'vue'
	import { useRouter } from 'vue-router'

	import apiClient from '@/services/api'
    import { useSessionStore } from '@/stores/session';

	const email = ref('')
	const pass = ref('')

    const router = useRouter()
    const sessionStore = useSessionStore()

	async function login(){
		await apiClient.post('login', {
			'email': email.value,
			'password': pass.value
		})
		.then(resp => {
			if(resp.data[0] == 'LOGIN_SUCCESS'){
                sessionStore.registerSession(resp.data[1])
                sessionStore.authenticate()

				if(sessionStore.session.role == 'Dosen'){
					router.push('/dashboard/dosen')
				}
				else if(sessionStore.session.role == 'Mahasiswa'){
					router.push('/dashboard/mahasiswa')
				}
				else if(sessionStore.session.role == 'Admin'){
					router.push('/dashboard/admin')
				}
            }
            else{
                alert('Login gagal! Silahkan cek kembali username / password anda.')
            }
		})
	}
</script>
<template>
  	<div class="bg-indigo h-screen w-screen flex items-center justify-center">
    	<div class="bg-white px-8 py-10 rounded-xl w-1/3 flex flex-col items-center justify-center gap-8">
      		<img src="@/assets/icon.png" class="w-1/3">

			<p class="text-indigo font-medium">Masukkan akun anda untuk melanjutkan.</p>

			<div class="flex flex-col gap-6 w-full text">
				<div class="flex relative">
					<p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">Email</p>
					<div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
						<fa icon="fas fa-envelope" class="text-indigo" fixed-width />
						<input type="email" v-model="email" class="border-0 p-0 outline-none w-full" placeholder="Masukkan email anda">
					</div>
				</div>
				<div class="flex relative">
					<p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">Password</p>
					<div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
						<fa icon="fas fa-lock" class="text-indigo" fixed-width />
						<input type="password" v-model="pass" class="border-0 p-0 outline-none w-full" placeholder="Masukkan password anda">
					</div>
				</div>

				<button @click="login()" class="bg-indigo p-4 rounded-xl w-full text-white text-xl font-semibold flex items-center justify-center">Masuk</button>

				<!-- <p class="text-indigo w-full text-center">Lupa password? Klik disini</p> -->
			</div>
    	</div>
	</div>  
</template>
