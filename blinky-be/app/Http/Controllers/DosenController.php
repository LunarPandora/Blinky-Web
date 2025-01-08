<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
{
    public function fetch(){
        $dosen = Dosen::all();

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
            'nidn' => $request->nidn
        ]);

        if($dosen){
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
