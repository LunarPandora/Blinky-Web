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

    public function create(Request $request){
        $absensi = Absensi::create([
            'id_mhswa' => $request->id_mahasiswa,
            'id_jadwal' => $request->id_jadwal,
            'waktu_absen' => $request->waktu_absen,
            'kode_status_absensi' => $request->kode_status_absensi
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

        $absensi->id_mhswa = $request->id_mhswa;
        $absensi->id_jadwal = $request->id_jadwal;
        $absensi->waktu_absen = $request->waktu_absen;
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
