<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Jadwal;
use App\Models\Pertemuan;
use App\Models\Kelas;
use App\Models\Absensi;

use Illuminate\Support\Carbon;

class JadwalController extends Controller
{
    public function fetch(Request $request){
        if($request->role == "Dosen"){
            $jadwal = Jadwal::whereRelation('dosen', 'id_dosen', '=', $request->id);
            
            if($request->id_kelas != '0'){
                $jadwal = $jadwal->whereRelation('kelas', 'id_kelas', '=', $request->id_kelas);
            }

            if($request->search != '' && !is_null($request->search)){
                $jadwal = $jadwal->whereRelation('matkul', 'nm_matkul', 'LIKE', '%' . $request->search . '%');
            }

            if($request->hari != '0'){
                $jadwal = $jadwal->where('hari', '=', $request->hari);
            }

            $jadwal = $jadwal->with(['kelas', 'dosen', 'matkul'])->get();
        } 
        else if($request->role == "Mahasiswa"){
            $jadwal = Jadwal::where([
                ['id_mahasiswa', '=', $request->id],
            ])
            ->with(['kelas', 'dosen', 'matkul'])->get();
        }
        
        return response($jadwal);
    }

    public function find(Request $request){
        $jadwal = Jadwal::where([
            ['id_jadwal', '=', $request->id_jadwal],
        ])
        ->with(['kelas', 'dosen', 'matkul', 'kelas.mahasiswa'])
        ->first();

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
            $cur = Carbon::createFromFormat('d-m-Y H:i:s', $request->date);
            $kel = Kelas::where('id_kelas', $request->id_kelas)
            ->with(['mahasiswa'])
            ->first();

            for($i = 0; $i < $request->pertemuan; $i++){
                $pertemuan = Pertemuan::create([
                    'id_jadwal' => $jadwal->id_jadwal,
                    'tanggal_pertemuan' => $cur->format('Y-m-d'),
                ]);


                $cur = $cur->add(7, 'day');
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
        $jadwal->pertemuan = $request->pertemuan;

        $jadwal->save();

        if($jadwal){
            $cur = Carbon::createFromFormat('d-m-Y H:i:s', $request->date);
            $pertemuan_list = Pertemuan::where(['id_jadwal', '=', $request->id_jadwal])->get();

            for($i = 0; $i < count($pertemuan_list); $i++){
                $pertemuan_list[$i]->tanggal_pertemuan = $cur->format('Y-m-d');

                $cur = $cur->add(7, 'day');
            }
            
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
