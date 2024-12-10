<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function get(Request $request){
        $u = User::where("id", $request->id)
        ->with(['roles', 'dosen_acc', 'mhswa_acc'])
        ->first();

        return response($u);
    }
}
