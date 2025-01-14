<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Pelajar;
use App\Models\User;

class PelajarController extends Controller
{
    // Untuk ambil semua data pelajar beserta kelas dan jurusan yang bersangkutan
    public function fetch(){
        $data = Pelajar::join('users', 'pelajar.id_pelajar', '=', 'users.pelajar_id')
        ->with(['kelas', 'jurusan'])->get();

        return response($data);
    }

    public function list(Request $request){
        $data = Pelajar::where('id_kelas', '=', $request->id_kelas)
        ->with(['kelas', 'jurusan', 'presensi'])
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

    public function create(Request $request){
        $nama_rn = '-';

        $pelajar = Pelajar::create([
            'no_pelajar' => $request->no_pelajar,
            'id_kelas' => $request->id_kelas,
            'id_jurusan' => $request->id_jurusan,
            'nm_pelajar' => $request->nm_pelajar,
            'angkatan' => $request->angkatan,
            'isActive' => $request->is_active,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'gender' => $request->gender,
            'agama' => $request->agama,
            'uid_rfid' => '-',
        ]);

        if($request->hasFile('picture')){
            $file = $request->file('picture');

            $nama_asli = $file->getClientOriginalName();
            $nama_rn = Str::random(12) . "." . $file->extension();

            $request->picture->move(public_path('storage/images'), $nama_rn);
        }

        $users = User::create([
            'role_id' => 2,
            'pelajar_id' => $pelajar->id_pelajar,
            'email' => $request->email,
            'password' => Hash::make($request->pw_pelajar),
            'user_picture' => $nama_rn
        ]);

        if($pelajar && $users){
            return response('Success');
        }
        else{
            return response('error');
        }
    }

    public function update(Request $request){
        $pelajar = Pelajar::find($request->id_pelajar);
        $user = User::where('pelajar_id', $request->id_pelajar);

        return response($pelajar);

        // $pelajar->no_pelajar = $request->no_pelajar;
        // $pelajar->nm_pelajar = $request->nm_pelajar;
        // $pelajar->id_kelas = $request->id_kelas;
        // $pelajar->id_jurusan = $request->id_jurusan;
        // $pelajar->angkatan = $request->angkatan;

        // $user->update(['email' => $request->email]);

        // if(!empty($request->password)){
        //     $user->update(['password' => Hash::make($request->password)]);
        // }

        // $pelajar->save();

        // if($pelajar && $user){
        //     return response('success');
        // }
        // else{
        //     return response('error');
        // }
    }

    public function delete(Request $request){
        $query = DB::table('tb_pelajar')
        ->where('id_pelajar', $request->no_pelajar)
        ->delete();

        if($query > 0){
            return response('success');
        }
        else{
            return response('error');
        }
    }
}
