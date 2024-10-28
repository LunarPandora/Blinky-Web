<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;

class ProdiController extends Controller
{
    public function fetch(){
        $prodi = Prodi::all();

        return response($prodi);
    }

    public function create(Request $request){
        $prodi = Prodi::create([
            'nm_prodi' => $request->nm_prodi
        ]);

        if($prodi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $prodi = Prodi::find($request->id_prodi);

        $prodi->nm_prodi = $request->nm_prodi;

        $prodi->save();

        if($prodi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $prodi = Prodi::find($request->id_prodi);
        $prodi->delete();

        if($prodi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
