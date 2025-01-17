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

				if(sessionStore.session.role == 'Pengajar'){
					router.push('/dashboard/pengajar')
				}
				else if(sessionStore.session.role == 'Pelajar'){
					router.push('/dashboard/pelajar')
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
  	<div class="bg-darkbrown h-screen w-screen flex items-center justify-center">
    	<div class="bg-cream px-8 py-10 rounded-xl w-1/3 flex flex-col items-center justify-center gap-8">
			<div class="w-full flex gap-6 items-center justify-center">
				<img src="@/assets/icon.svg" class="w-1/6">
				<h1 class="logo text-6xl text-darkbrown">Blinky.</h1>
			</div>

			<p class="text-lg">Masukkan akun anda untuk melanjutkan.</p>

			<div class="flex flex-col gap-6 w-full text">
				<div class="bg-softcream p-4 rounded-xl flex flex-col w-full gap-3">
					<div class="flex items-center gap-3">
						<fa icon="fas fa-envelope" class="text-darkbrown" fixed-width />
						<p class="text-darkbrown">Email</p>
					</div>

					<input type="text" class="text-darkbrown text-sm bg-transparent w-full outline-none" placeholder="Masukkan email anda..." v-model="email" />
				</div>

				<div class="bg-softcream p-4 rounded-xl flex flex-col w-full gap-3">
					<div class="flex items-center gap-3">
						<fa icon="fas fa-lock" class="text-darkbrown" fixed-width />
						<p class="text-darkbrown">Password</p>
					</div>

					<input type="password" class="text-darkbrown text-sm bg-transparent w-full outline-none" placeholder="Masukkan password anda" v-model="pass" />
				</div>

				<button @click="login()" class="bg-darkbrown p-4 rounded-xl w-full text-softcream text-xl font-semibold flex items-center justify-center">Masuk</button>

				<!-- <p class="text-darkbrown w-full text-center">Lupa password? Klik disini</p> -->
			</div>
    	</div>
	</div>  
</template>
