<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusAbsensi;

class StatusAbsensiController extends Controller
{
    public function fetch(){
        $statusabsensi = StatusAbsensi::all();

        return response($statusabsensi);
    }

    public function create(Request $request){
        $statusabsensi = StatusAbsensi::create([
            'status_absensi' => $request->status_absensi
        ]);

        if($statusabsensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $statusabsensi = StatusAbsensi::find($request->kode_status_absensi);

        $statusabsensi->status_absensi = $request->status_absensi;

        $statusabsensi->save();

        if($statusabsensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $statusabsensi = StatusAbsensi::find($request->kode_status_absensi);
        $statusabsensi->delete();

        if($statusabsensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
