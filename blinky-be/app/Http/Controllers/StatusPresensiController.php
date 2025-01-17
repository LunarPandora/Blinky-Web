<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusPresensi;

class StatusPresensiController extends Controller
{
    public function fetch(){
        $statuspresensi = StatusPresensi::all();

        return response($statuspresensi);
    }

    public function create(Request $request){
        $statuspresensi = StatusPresensi::create([
            'status_presensi' => $request->status_presensi
        ]);

        if($statuspresensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $statuspresensi = StatusPresensi::find($request->kode_status_presensi);

        $statuspresensi->status_presensi = $request->status_presensi;

        $statuspresensi->save();

        if($statuspresensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $statuspresensi = StatusPresensi::find($request->kode_status_presensi);
        $statuspresensi->delete();

        if($statuspresensi){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
