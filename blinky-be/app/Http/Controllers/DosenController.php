<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
{
    public function fetch(){
        $dosen = Dosen::with(['prodi'])->get();

        return response($dosen);
    }

    public function list(Request $request){
        $dosen = Dosen::where('id_dosen', '=', $request->id_dosen)
        ->with(['prodi'])
        ->get();

        return response($dosen);
    }

    public function create(Request $request){
        $dosen = Dosen::create([
            'id_prodi' => $request->id_prodi,
            'nm_dosen' => $request->nm_dosen,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn
        ]);

        $users = User::create([
            'role_id' => 1,
            'dosen_id' => $dosen->id,
            'email' => $request->email,
            'password' => Hash::make($request->pw_dosen),
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
