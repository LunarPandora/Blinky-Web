<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Presensi;
use App\Models\Jadwal;
use App\Models\User;

class PresensiController extends Controller
{
    public function fetch(){
        $presensi = Presensi::all();

        return response($presensi);
    }

    public function list(Request $request){
        $attendanceList = array();

        $pelajar = Jadwal::where('id_jadwal', $request->id_jadwal)
        ->with(['kelas', 'kelas.pelajar', 'kelas.pelajar.acc'])
        ->first();

        foreach($pelajar->kelas->pelajar as $x){
            $presensi = Presensi::where([
                ['id_kelas', '=', $pelajar->kelas->id_kelas],
                ['id_pelajar', '=', $x->id_pelajar],
                ['id_pertemuan', '=', $request->id_pertemuan]
            ]);

            if(!$presensi->exists()){
                array_push($attendanceList, [
                    'nim' => $x->nim,
                    'id_pelajar' => $x->id_pelajar,
                    'id_kelas' => $x->id_kelas,
                    'nm_pelajar' => $x->nm_pelajar,
                    'angkatan' => $x->angkatan,
                    'user_pic' => $x->acc[0]->user_picture,
                    'waktu_presensi' => null,
                    'kode_status_presensi' => 0
                ]);
            }
            else{
                $presensi = $presensi->first();
 
                array_push($attendanceList, [
                    'nim' => $x->nim,
                    'id_presensi' => $presensi->id_presensi,
                    'id_pelajar' => $x->id_pelajar,
                    'id_kelas' => $x->id_kelas,
                    'nm_pelajar' => $x->nm_pelajar,
                    'angkatan' => $x->angkatan,
                    'user_pic' => $x->acc[0]->user_picture,
                    'updated_at' => $presensi->updated_at,
                    'keterangan' => $presensi->keterangan,
                    'kode_status_presensi' => $presensi->kode_status_presensi
                ]);
            }
        }

        return response($attendanceList);
    }

    public function list_pertemuan(Request $request){
        $presensi = Presensi::selectRaw('pertemuan, count(*) as total')
        ->where([
            ['id_jadwal', '=', $request->id_jadwal] 
        ])
        ->groupBy('pertemuan')
        ->get();

        return response($presensi);
    }

    public function create(Request $request){
        $presensi = Presensi::create([
            'id_kelas' => $request->id_kelas,
            'id_pelajar' => $request->id_pelajar,
            'id_pertemuan' => $request->id_pertemuan,
            'kode_status_presensi' => $request->kode_status_presensi,
            'waktu_presensi' => Carbon::now(),
        ]);

        if($presensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $presensi = Presensi::find($request->id_presensi);

        $presensi->waktu_presensi = Carbon::now();
        $presensi->kode_status_presensi = $request->kode_status_presensi;
        $presensi->save();

        if($presensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update_ket(Request $request){
        $presensi = Presensi::find($request->id_presensi);
        
        $presensi->keterangan = $request->keterangan;
        $presensi->save();

        if($presensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $presensi = Presensi::find($request->id_presensi);
        $presensi->delete();

        if($presensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
