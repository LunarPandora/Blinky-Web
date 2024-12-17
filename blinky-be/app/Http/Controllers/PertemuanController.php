<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pertemuan;
use App\Models\Absensi;
use App\Models\Mahasiswa;

class PertemuanController extends Controller
{
    public function fetch(Request $request){
        $pertemuan = Pertemuan::where('id_jadwal', '=', $request->id_jadwal)
        ->get();

        return response()->json($pertemuan);
    }

    public function find(Request $request){
        $ptmn = Pertemuan::where('id_pertemuan', '=', $request->id_pertemuan)
        ->with(['jadwal'])
        ->first();

        // $attendanceList = [];

        // $attendanceList = $pertemuan->map(function ($user) {
        // for($i = 0; $i < count($ptmn->jadwal->kelas->mahasiswa); $i++){
        $cekAbsensi = Mahasiswa::where([
            ['id_kelas', '=', $ptmn->jadwal->id_kelas],
        ])
        ->with(['absensi'])
        ->get();

        $attendanceList = $cekAbsensi->map(function ($user) use ($request) {
            for($i = 0; $i < count($user->absensi); $i++){
                if($user->absensi[$i]->id_pertemuan == $request->id_pertemuan){
                    return [$user->absensi[$i], 'success'];
                }
                else{
                    return [$user->absensi[$i], 'fail'];
                }
            };
        });

        // $cekAbsensi = Absensi::where([
        //     ['id_kelas', '=', $ptmn->jadwal->id_kelas],
        //     ['id_mhswa', '=', $ptmn->jadwal->kelas->mahasiswa[$i]->id_mhswa],
        //     ['id_pertemuan', '=', $ptmn->id_pertemuan]
        // ])
        // ->with(['mahasiswa']);
                
        // if($cekAbsensi->get()->isNotEmpty()){
        // array_push($attendanceList, $cekAbsensi);
            // }
        // }
        // });

        return response()->json($attendanceList);
    }
}
