<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function fetch(){
        $jadwal = Jadwal::all();

        return response($jadwal);
    }

    public function create(Request $request){
        $jadwal = Jadwal::create([
            'id_jadwal' => $request->id_jadwal
        ]);

        if($jadwal){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $jadwal = Jadwal::find($request->id_jadwal);

        $jadwal->id_jadwal = $request->id_jadwal;

        $jadwal->save();

        if($jadwal){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $jadwal = Jadwal::find($request->id_jadwal);
        $jadwal->delete();

        if($jadwal){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
