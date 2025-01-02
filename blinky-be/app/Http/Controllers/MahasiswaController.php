<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Mahasiswa;
use App\Models\User;

class MahasiswaController extends Controller
{
    // Untuk ambil semua data mahasiswa beserta kelas dan prodi yang bersangkutan
    public function fetch(){
        $data = Mahasiswa::join('users', 'mahasiswa.id_mhswa', '=', 'users.mhswa_id')
        ->with(['kelas', 'prodi'])->get();

        return response($data);
    }

    public function list(Request $request){
        $data = Mahasiswa::where('id_kelas', '=', $request->id_kelas)
        ->with(['kelas', 'prodi', 'absensi'])
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

    // Ini mau disesuaikan dengan model yang baru nanti - WY

    public function insert(Request $request){
        $mhswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nm_mhswa' => $request->nm_mhswa,
            'id_kelas' => $request->id_kelas,
            'id_prodi' => $request->id_prodi,
            'angkatan' => $request->angkatan,
            'uid_rfid' => '-',
        ]);

        $users = User::create([
            'role_id' => 2,
            'mhswa_id' => $mhswa->id_mhswa,
            'email' => $request->email,
            'password' => Hash::make($request->pw_mhswa),
        ]);

        if($mhswa && $users){
            return response('success');
        }
        else{
            return response('error');
        }
    }

    public function update(Request $request){
        $mhswa = Mahasiswa::find($request->id_mhswa);
        $user = User::where('mhswa_id', $request->id_mhswa);

        return response($mhswa);

        // $mhswa->nim = $request->nim;
        // $mhswa->nm_mhswa = $request->nm_mhswa;
        // $mhswa->id_kelas = $request->id_kelas;
        // $mhswa->id_prodi = $request->id_prodi;
        // $mhswa->angkatan = $request->angkatan;

        // $user->update(['email' => $request->email]);

        // if(!empty($request->password)){
        //     $user->update(['password' => Hash::make($request->password)]);
        // }

        // $mhswa->save();

        // if($mhswa && $user){
        //     return response('success');
        // }
        // else{
        //     return response('error');
        // }
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
