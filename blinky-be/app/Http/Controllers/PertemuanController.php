<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertemuan;

class PertemuanController extends Controller
{
    public function fetch(Request $request){
        $pertemuan = Pertemuan::where('id_jadwal', '=', $request->id_jadwal)
        // ->with(['absensi'])
        ->get();

        return response()->json($pertemuan);
    }

    public function find(Request $request){
        // $pertemuan = Pertemuan::where([
        //     ['id_pertemuan', '=', $request->id_pertemuan],
        // ])
        // ->with(['jadwal', 'absensi'])
        // ->get();

        // $pertemuan = Pertemuan::all();
        // $pertemuan = Pertemuan::find($request->id_pertemuan);
        $pertemuan = Pertemuan::where('id_pertemuan', $request->id_pertemuan)
                    ->with(['jadwal', 'absensi'])
                    ->get();

        return response($pertemuan);
    }
}
