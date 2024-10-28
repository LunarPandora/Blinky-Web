<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function fetch(){
        $kelas = Kelas::all();

        return response($kelas);
    }

    public function create(Request $request){
        $kelas = Kelas::create([
            'nm_kelas' => $request->nm_kelas
        ]);

        if($kelas){
            return response('Success!');
        }
        else {
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $kelas = Kelas::find($request->id_kelas);

        $kelas->nm_kelas = $request->nm_kelas;

        $kelas->save();

        if($kelas){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $kelas = Kelas::find($request->id_kelas);
        $kelas->delete();

        if($kelas){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
