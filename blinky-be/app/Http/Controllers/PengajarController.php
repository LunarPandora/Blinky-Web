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
        $nama_rn = '-';

        $pengajar = Pengajar::create([
            'id_jurusan' => $request->id_jurusan,
            'nm_pengajar' => $request->nm_pengajar,
            'jabatan' => $request->jabatan,
            'no_pengajar' => $request->no_pengajar,
            'tipe_pengajar' => $request->tipe_pengajar,
            'isActive' => $request->is_active,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'gender' => $request->gender,
            'agama' => $request->agama  
        ]);

        if($request->hasFile('picture')){
            $file = $request->file('picture');

            $nama_asli = $file->getClientOriginalName();
            $nama_rn = Str::random(12) . "." . $file->extension();

            $request->picture->move(public_path('storage/images'), $nama_rn);
        }

        $users = User::create([
            'role_id' => 3,
            'pengajar_id' => $pengajar->id_pengajar,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_picture' => $nama_rn
        ]);

        if($pengajar && $users){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $pengajar = Pengajar::find($request->id_pengajar);
        $u = User::where('pengajar_id', '=', $request->id_pengajar)->first();

        $pengajar->id_jurusan = $request->id_jurusan;
        $pengajar->nm_pengajar = $request->nm_pengajar;
        $pengajar->jabatan = $request->jabatan;
        $pengajar->no_pengajar = $request->no_pengajar;
        $pengajar->tipe_pengajar = $request->tipe_pengajar;
        $pengajar->isActive = $request->is_active;
        $pengajar->no_telp = $request->no_telp;
        $pengajar->alamat = $request->alamat;
        $pengajar->gender = $request->gender;
        $pengajar->agama = $request->agama;

        $u->email = $request->email;
        if($request->password != ''){
            $u->password = Hash::make($request->password);
        }
        if($request->hasFile('picture')){
            $file = $request->file('picture');

            $nama_asli = $file->getClientOriginalName();
            $nama_rn = Str::random(12) . "." . $file->extension();

            $request->picture->move(public_path('storage/images'), $nama_rn);
            File::delete(public_path('storage/images/' . $u->user_picture));

            $u->user_picture = $nama_rn;
        }

        $u->save();
        $pengajar->save();

        if($u && $pengajar){
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
