<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $cred = $request->validate([
            'email' => ['required'],
            'pass' => ['required'],
            // 'role' => ['required'] (Untuk bedakan mahasiswa dan dosen)
        ]);

        $auth_mhswa = Auth::attempt([
            'email' => $request->email,
            'password' => $request->pass,   
        ]);

        if($auth_mhswa){
            $request->session()->regenerate();

            return response('Berhasil masuk!');
        }

        return response($auth_mhswa);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response('Berhasil logout!');
    }
}
