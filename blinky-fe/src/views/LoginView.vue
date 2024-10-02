<script setup>
	import { RouterLink } from 'vue-router'

</script>
<template>
  	<div class="bg-indigo h-screen w-screen flex items-center justify-center">
    	<div class="bg-white px-8 py-10 rounded-xl w-1/3 flex flex-col items-center justify-center gap-8">
      		<img src="@/assets/icon.png" class="w-1/3">

			<p class="text-indigo font-medium">Masukkan akun anda untuk melanjutkan.</p>

			<div class="flex flex-col gap-6 w-full text">
				<div class="flex relative">
					<p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">Username</p>
					<div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
						<fa icon="fas fa-user" class="text-indigo" fixed-width />
						<input type="text" class="border-0 p-0 outline-none w-full" placeholder="Masukkan username anda">
					</div>
				</div>
				<div class="flex relative">
					<p class="bg-white absolute top-[-11px] left-5 px-1 text-sm text-indigo">Password</p>
					<div class="bg-white p-4 border-[2px] border-indigo rounded-xl flex items-center w-full gap-3">
						<fa icon="fas fa-lock" class="text-indigo" fixed-width />
						<input type="text" class="border-0 p-0 outline-none w-full" placeholder="Masukkan password anda">
					</div>
				</div>

				<RouterLink to="dashboard/admin" class="bg-indigo p-4 rounded-xl w-full text-white text-xl font-semibold flex items-center justify-center">Masuk</RouterLink>

				<p class="text-indigo w-full text-center">Lupa password? Klik disini</p>
			</div>
    	</div>
	</div>  
</template>
