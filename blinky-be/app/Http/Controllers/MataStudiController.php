<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataStudi;

class MataStudiController extends Controller
{
    public function fetch(){
        $mata_studi = MataStudi::all();

        return response($mata_studi);
    }

    public function create(Request $request){
        $mata_studi = MataStudi::create([
            'nm_mata_studi' => $request->nm_mata_studi
        ]);

        if($mata_studi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $mata_studi = MataStudi::find($request->id_mata_studi);

        $mata_studi->nm_mata_studi = $request->nm_mata_studi;

        $mata_studi->save();

        if($mata_studi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $mata_studi = MataStudi::find($request->id_mata_studi);
        $mata_studi->delete();

        if($mata_studi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
