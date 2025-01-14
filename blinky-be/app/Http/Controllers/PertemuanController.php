<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pertemuan;
use App\Models\Presensi;
use App\Models\Pelajar;

class PertemuanController extends Controller
{
    public function fetch(Request $request){
        $pertemuan = Pertemuan::where('id_jadwal', '=', $request->id_jadwal)
        ->with(['jadwal','presensi', 'presensi.status'])
        ->get();

        return response()->json($pertemuan);
    }

    public function find(Request $request){
        $pertemuan = Pertemuan::where('id_pertemuan', $request->id_pertemuan)
                    ->with(['jadwal', 'presensi'])
                    ->first();

        return response($pertemuan);
    }
}
