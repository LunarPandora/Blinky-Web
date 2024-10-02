<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function fetch(){
        $data = DB::table('tb_mahasiswa')
        ->join('tb_kelas', 'tb_mahasiswa.id_kelas', '=', 'tb_kelas.id_kelas')
        ->join('tb_prodi', 'tb_mahasiswa.id_prodi', '=', 'tb_prodi.id_prodi')
        ->select('tb_mahasiswa.*', 'tb_kelas.nm_kelas', 'tb_prodi.nm_prodi')
        ->get();

        return response($data);
    }

    public function register_card(Request $request){
        $tmp_ms = DB::table('machine')->update([
            'last_rec_rfid' => $request->uid_rfid
        ]);

        if($query > 0){
            return response('success');
        }
        else{
            return response('error');
        }
    }

    public function check_machine(){
        $m = DB::table('machine')->get();
        
        return response($m[0]->is_scanning);
    }

    public function insert(Request $request){
        $data = [
            'id_mhswa' => $request->nim,
            'id_kelas' => $request->kelas,
            'id_prodi' => $request->prodi,
            'id_admin' => '201',
            'nm_mahasiswa' => $request->nama,
            'pw_mahasiswa' => Hash::make($request->pw),
            'angkatan' => $request->angkatan,
            'uid_rfid' => '-'
        ];

        $query = DB::table('tb_mahasiswa')
        ->insert($data);

        if($query > 0){
            return response('success');
        }
        else{
            return response('error');
        }
    }

    public function update(Request $request){
        $data = [
            'id_mhswa' => $request->nim_baru,
            'nm_mahasiswa' => $request->nama,
            'id_kelas' => $request->kelas,
            'id_prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
        ];

        if($request->pw != ''){
            $data['pw_mahasiswa'] = Hash::make($request->pw);
        }

        $query = DB::table('tb_mahasiswa')
        ->where('id_mhswa', $request->nim_lama)
        ->update($data);

        if($query > 0){
            return response('success');
        }
        else{
            return response('error');
        }
    }

    public function delete(Request $request){
        $query = DB::table('tb_mahasiswa')
        ->where('id_mhswa', $request->nim)
        ->delete();

        if($query > 0){
            return response('success');
        }
        else{
            return response('error');
        }
    }
}
