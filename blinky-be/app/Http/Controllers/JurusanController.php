<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function fetch(){
        $jurusan = Jurusan::all();

        return response($jurusan);
    }

    public function create(Request $request){
        $jurusan = Jurusan::create([
            'nm_jurusan' => $request->nm_jurusan
        ]);

        if($jurusan){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $jurusan = Jurusan::find($request->id_jurusan);
        
        $jurusan->nm_jurusan = $request->nm_jurusan;

        $jurusan->save();

        if($jurusan){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $jurusan = Jurusan::find($request->id_jurusan);
        $jurusan->delete();

        if($jurusan){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
