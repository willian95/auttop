<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminEmail;

class AdminEmailController extends Controller
{

    function index(){
        return view('admin.email.index');
    }

    function store(Request $request){

        try{

            $email = new AdminEmail;
            $email->email = $request->email;
            $email->save();

            return response()->json(["success" => true, "msg" => "Email creado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(Request $request){

        try{

            $email = AdminEmail::find($request->emailId);
            $email->email = $request->email;
            $email->update();

            return response()->json(["success" => true, "msg" => "Email actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function delete(Request $request){

        try{

            $email = AdminEmail::find($request->emailId);
            $email->delete();

            return response()->json(["success" => true, "msg" => "Email eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch(){

        try{

            $emails = AdminEmail::all();

            return response()->json(["success" => true, "emails" => $emails]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
