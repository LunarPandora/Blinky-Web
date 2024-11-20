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
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Pertemuan 1</td>
                    <td>19/11/2024</td>
                    <td>Hadir</td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Pertemuan 2</td>
                    <td>26/11/2024</td>
                    <td>Hadir</td>
                </tr>
                <tr class="bg-white border-b-2 border-b-gray-200 text-black *:px-3 *:py-2 *:text-sm *:tracking-wide *:text-center">
                    <td>Pertemuan 3</td>
                    <td>03/12/2024</td>
                    <td>Hadir</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>