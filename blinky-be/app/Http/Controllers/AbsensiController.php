<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    public function fetch(){
        $absensi = Absensi::all();

        return response($absensi);
    }

    public function list(Request $request){
        $absensi = Absensi::where([
            ['id_pertemuan', '=', $request->id_pertemuan],
            // ['id_jadwal', '=', $request->id_jadwal]
        ])
        ->with(['kelas', 'mahasiswa', 'pertemuan.jadwal.kelas'])
        ->get();

        return response($absensi);
    }

    public function list_pertemuan(Request $request){
        $absensi = Absensi::selectRaw('pertemuan, count(*) as total')
        ->where([
            ['id_jadwal', '=', $request->id_jadwal] 
        ])
        ->groupBy('pertemuan')
        ->get();

        return response($absensi);
    }

    public function create(Request $request){
        $absensi = Absensi::create([
            'id_mhswa' => $request->id_mhswa,
            'id_kelas' => $request->id_kelas,
            'id_jadwal' => $request->id_jadwal,
            'waktu_absen' => $request->date . " " . $request->time,
            'kode_status_absensi' => $request->kode_status_absensi,
            'pertemuan' => $request->pertemuan
        ]);

        if($absensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $absensi = Absensi::find($request->id_absensi);

        // $absensi->waktu_absen = $request->waktu_absen;
        $absensi->kode_status_absensi = $request->kode_status_absensi;
        $absensi->save();

        if($absensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $absensi = Absensi::find($request->id_absensi);
        $absensi->delete();

        if($absensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
