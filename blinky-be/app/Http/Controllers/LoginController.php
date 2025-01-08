<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request){
        $cred = $request->validate([
            'email' => 'required',
            'password' => 'required',
            // 'role' => ['required'] (Untuk bedakan mahasiswa dan dosen)
        ]);

        $auth = Auth::attempt($cred);

        if($auth){
            $request->session()->regenerate();

            $ud = User::where('id', '=', Auth::id())
            ->with(['dosen_acc', 'mhswa_acc', 'dosen_acc.prodi', 'mhswa_acc.prodi'])
            ->first();

            $session_dt = array(
                'id' => $ud->id,
                'role' => $ud->roles->role_name,
                'dosen' => $ud->dosen_acc,
                'mhswa' => $ud->mhswa_acc,
                'email' => $ud->email,
                'user_picture' => $ud->user_picture,
            );

            return response(['LOGIN_SUCCESS', $session_dt]);
        }
        else{
            return response('LOGIN_FAILED');
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response('LOGOUT_SUCCESS');
    }
}
