<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Dosen;

class UserController extends Controller
{
    public function get(Request $request){
        $u = User::where("id", $request->id)
        ->with(['roles', 'dosen_acc', 'mhswa_acc', 'dosen_acc.prodi', 'mhswa_acc.prodi'])
        ->first();

        $session_dt = array(
            'id' => $u->id,
            'role' => $u->roles->role_name,
            'dosen' => $u->dosen_acc,
            'mhswa' => $u->mhswa_acc,
            'email' => $u->email,
            'user_picture' => $u->user_picture,
        );

        return response($session_dt);
    }

    public function update(Request $request){
        $role = $request->role;

        if($role == 'Dosen'){
            $u = User::find($request->id);
            $d = Dosen::find($u->dosen_id);

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

            $d->no_telp = $request->no_telp;
            $d->alamat = $request->alamat;
            $d->gender = $request->gender;
            $d->agama = $request->agama;

            $d->save();
            $u->save();

            if($d && $u){
                return response('Success!');
            }
            else{
                return response('Failed!');
            }
        }
        elseif($role == 'Mahasiswa'){
            $u = User::find($request->id);
            $m = Mahasiswa::find($u->mhswa_id);

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

            $m->no_telp = $request->no_telp;
            $m->alamat = $request->alamat;
            $m->gender = $request->gender;
            $m->agama = $request->agama;

            $m->save();
            $u->save();

            if($m && $u){
                return response('Success!');
            }
            else{
                return response('Failed!');
            }
        }
    }
}
