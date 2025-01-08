<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Dosen;
use App\Models\User;

class DosenController extends Controller
{
    public function fetch(){
        $dosen = Dosen::with(['prodi', 'acc'])->get();

        return response($dosen);
    }

    public function list(Request $request){
        $dosen = Dosen::where('id_dosen', '=', $request->id_dosen)
        ->with(['prodi'])
        ->get();

        return response($dosen);
    }

    public function fetch_list(Request $request){
        $dosen = Dosen::where('id_prodi', '=', $request->id_prodi)->get();

        return response($dosen);
    }

    public function get(Request $request){
        $dosen = Dosen::find($request->id);

        return response($dosen);
    }

    public function create(Request $request){
        $dosen = Dosen::create([
            'id_prodi' => $request->id_prodi,
            'nm_dosen' => $request->nm_dosen,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn,
            'isActive' => $request->isActive,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'gender' => $request->gender,
            'agama' => $request->agama
        ]);

        $users = User::create([
            'role_id' => 1,
            'dosen_id' => $dosen->id,
            'email' => $request->email,
            'password' => Hash::make($request->pw_dosen),
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
        $dosen = Dosen::find($request->id_dosen);

        $dosen->id_prodi = $request->id_prodi;
        $dosen->nm_dosen = $request->nm_dosen;
        $dosen->jabatan = $request->jabatan;
        $dosen->nidn = $request->nidn;
        $dosen->isActive = $request->isActive;
        $dosen->no_telp = $request->no_telp;
        $dosen->alamat = $request->alamat;
        $dosen->gender = $request->gender;
        $dosen->agama = $request->agama;

        $dosen->save();

        if($dosen){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $dosen = Dosen::find($request->id_dosen);
        $dosen->delete();

        if($dosen){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
