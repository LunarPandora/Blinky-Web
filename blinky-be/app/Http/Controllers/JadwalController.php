<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Jadwal;
use App\Models\Pertemuan;

class JadwalController extends Controller
{
    public function fetch(){
        $jadwal = Jadwal::with(['kelas', 'dosen', 'matkul'])->get();

        return response($jadwal);
    }

    public function find(Request $request){
        $jadwal = Jadwal::where([
            ['id_jadwal', '=', $request->id_jadwal],
        ])
        ->with(['kelas', 'dosen', 'matkul'])
        ->get();

        return response($jadwal);
    }

    public function create(Request $request){
        $jadwal = Jadwal::create([
            'id_kelas' => $request->id_kelas,
            'id_dosen' => $request->id_dosen,
            'id_matkul' => $request->id_matkul,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'hari' => $request->hari,
            'pertemuan' => $request->pertemuan,
        ]);

        if($jadwal){
            for($i = 1; $i <= $request->pertemuan; $i++){
                $pertemuan = Pertemuan::create([
                    'id_jadwal' => $jadwal->id_jadwal,
                    // 'tanggal_pertemuan' => 
                ]);
            }

            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $jadwal = Jadwal::find($request->id_jadwal);

        $jadwal->id_kelas = $request->id_kelas;
        $jadwal->id_dosen = $request->id_dosen;
        $jadwal->id_matkul = $request->id_matkul;
        $jadwal->jam_mulai = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;
        $jadwal->hari = $request->hari;

        $jadwal->save();

        if($jadwal){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $jadwal = Jadwal::find($request->id_jadwal);
        $jadwal->delete();

        if($jadwal){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
