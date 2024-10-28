<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;

class RolesController extends Controller
{
    public function fetch(){
        $roles = Roles::all();

        return response($roles);
    }

    public function create(Request $request){
        $roles = Roles::create([
            'role_name' => $request->role_name
        ]);

        if($roles){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function update(Request $request){
        $roles = Roles::find($request->id);

        $roles->role_name = $request->role_name;

        $roles->save();

        if($roles){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }

    public function delete(Request $request){
        $roles = Roles::find($request->id);
        $roles->delete();

        if($roles){
            return response('Success!');
        }
        else{
            return response('Failed!');
        }
    }
}
