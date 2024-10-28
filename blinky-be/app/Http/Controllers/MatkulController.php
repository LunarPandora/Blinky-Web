<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matkul;

class MatkulController extends Controller
{
    public function fetch(){
        $matkul = Matkul::all();

        return response($matkul);
    }

    public function create(Request $request){
        $matkul = Matkul::create([
            'nm_matkul' => $request->nm_matkul
        ]);

        if($matkul){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $matkul = Matkul::find($request->id_matkul);

        $matkul->nm_matkul = $request->nm_matkul;

        $matkul->save();

        if($matkul){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $matkul = Matkul::find($request->id_matkul);
        $matkul->delete();

        if($matkul){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
