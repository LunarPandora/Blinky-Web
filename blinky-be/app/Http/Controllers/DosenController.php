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

    public function create(Request $request){
        $dosen = Dosen::create([
            'nm_dosen' => $request->nama_dosen
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

        $dosen->nm_dosen = $request->nama_dosen;

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
