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

            $ud = User::where('id', '=', Auth::id())->with(['dosen_acc', 'mhswa_acc'])->first();

            $session_dt = array(
                'id' => $ud->id,
                'role' => $ud->roles->role_name,
                'dosen' => $ud->dosen,
                'mhswa' => $ud->mhswa,
                'email' => $ud->dosen,
                'user_picture' => $ud->user_picture,
            );

            if($ud->roles->role_name == 'Dosen'){
                $session_dt['acc'] = $ud->  dosen_acc;
            }
            elseif($ud->roles->role_name == 'Mahasiswa'){
                $session_dt['acc'] = $ud->mhswa_acc;
            }

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

    public function generate(Request $request){
        return response(Hash::make('admin456'));
    }
}
