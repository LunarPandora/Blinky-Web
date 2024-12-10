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
}
