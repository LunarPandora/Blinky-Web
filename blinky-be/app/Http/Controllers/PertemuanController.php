<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pertemuan;
use App\Models\Absensi;
use App\Models\Mahasiswa;

class PertemuanController extends Controller
{
    public function fetch(Request $request){
        $pertemuan = Pertemuan::where('id_jadwal', '=', $request->id_jadwal)
        ->with(['absensi'])
        ->get();

        return response()->json($pertemuan);
    }

    public function find(Request $request){
        $pertemuan = Pertemuan::where('id_pertemuan', $request->id_pertemuan)
                    ->with(['jadwal', 'absensi'])
                    ->first();

        return response($pertemuan);
    }
}
