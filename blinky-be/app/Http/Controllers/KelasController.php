<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function fetch(){
        $data = DB::table('tb_kelas')
        ->get();

        return response($data);
    }
}
