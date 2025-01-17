<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengajar;
use App\Models\User;

class PengajarController extends Controller
{
    public function fetch(){
        $pengajar = Pengajar::with(['jurusan', 'acc'])->get();

        return response($pengajar);
    }

    public function list(Request $request){
        $pengajar = Pengajar::where('id_pengajar', '=', $request->id_pengajar)
        ->with(['jurusan'])
        ->get();

        return response($pengajar);
    }

    public function fetch_list(Request $request){
        $pengajar = Pengajar::where('id_jurusan', '=', $request->id_jurusan)->get();

        return response($pengajar);
    }

    public function get(Request $request){
        $pengajar = Pengajar::find($request->id);

        return response($pengajar);
    }

    public function create(Request $request){
        $pengajar = Pengajar::create([
            'id_jurusan' => $request->id_jurusan,
            'nm_pengajar' => $request->nm_pengajar,
            'jabatan' => $request->jabatan,
            'no_pengajar' => $request->no_pengajar,
            'tipe_pengajar' => $request->tipe_pengajar,
            'isActive' => $request->isActive,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'gender' => $request->gender,
            'agama' => $request->agama
        ]);

        $users = User::create([
            'role_id' => 2,
            'pengajar_id' => $pengajar->id_pengajar,
            'email' => $request->email,
            'password' => Hash::make($request->pw_pengajar),
            'user_picture' => '-'
        ]);

        if($users){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $pengajar = Pengajar::find($request->id_pengajar);

        $pengajar->id_jurusan = $request->id_jurusan;
        $pengajar->nm_pengajar = $request->nm_pengajar;
        $pengajar->jabatan = $request->jabatan;
        $pengajar->no_pengajar = $request->no_pengajar;
        $pengajar->isActive = $request->isActive;
        $pengajar->no_telp = $request->no_telp;
        $pengajar->alamat = $request->alamat;
        $pengajar->gender = $request->gender;
        $pengajar->agama = $request->agama;

        $pengajar->save();

        if($pengajar){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $pengajar = Pengajar::find($request->id_pengajar);
        $pengajar->delete();

        if($pengajar){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
