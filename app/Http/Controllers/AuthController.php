<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{   
    
    function loginIndex(){
        return view('login');
    }

    function login(LoginRequest $request){

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, true)) {
            
            return response()->json(["success" => true, "msg" => "Has iniciado sesión", "user" => Auth::user()]);
        
        }

        return response()->json(["success" => false, "msg" => "Usuario no encontrado"]);

    }

    function logout(){
        Auth::logout();
        return redirect()->to("/");
    }

}
