<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\User;

class AbsensiController extends Controller
{
    public function fetch(){
        $absensi = Absensi::all();

        return response($absensi);
    }

    public function list(Request $request){
        $attendanceList = array();

        $mhswa = Jadwal::where('id_jadwal', $request->id_jadwal)
        ->with(['kelas', 'kelas.mahasiswa', 'kelas.mahasiswa.acc'])
        ->first();

        foreach($mhswa->kelas->mahasiswa as $x){
            $absensi = Absensi::where([
                ['id_kelas', '=', $mhswa->kelas->id_kelas],
                ['id_mhswa', '=', $x->id_mhswa],
                ['id_pertemuan', '=', $request->id_pertemuan]
            ]);

            if(!$absensi->exists()){
                array_push($attendanceList, [
                    'nim' => $x->nim,
                    'id_mhswa' => $x->id_mhswa,
                    'id_kelas' => $x->id_kelas,
                    'nm_mhswa' => $x->nm_mhswa,
                    'angkatan' => $x->angkatan,
                    'user_pic' => $x->acc[0]->user_picture,
                    'waktu_absen' => null,
                    'kode_status_absensi' => 0
                ]);
            }
            else{
                $absensi = $absensi->first();
 
                array_push($attendanceList, [
                    'nim' => $x->nim,
                    'id_absensi' => $absensi->id_absensi,
                    'id_mhswa' => $x->id_mhswa,
                    'id_kelas' => $x->id_kelas,
                    'nm_mhswa' => $x->nm_mhswa,
                    'angkatan' => $x->angkatan,
                    'user_pic' => $x->acc[0]->user_picture,
                    'updated_at' => $absensi->updated_at,
                    'keterangan' => $absensi->keterangan,
                    'kode_status_absensi' => $absensi->kode_status_absensi
                ]);
            }
        }

        return response($attendanceList);
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
            'id_kelas' => $request->id_kelas,
            'id_mhswa' => $request->id_mhswa,
            'id_pertemuan' => $request->id_pertemuan,
            'kode_status_absensi' => $request->kode_status_absensi,
            'waktu_absen' => Carbon::now(),
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

        $absensi->waktu_absen = Carbon::now();
        $absensi->kode_status_absensi = $request->kode_status_absensi;
        $absensi->save();

        if($absensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update_ket(Request $request){
        $absensi = Absensi::find($request->id_absensi);
        
        $absensi->keterangan = $request->keterangan;
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
