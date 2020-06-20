<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MechanicStoreRequest;
use App\Http\Requests\MechanicUpdateRequest;
use App\User;

class MechanicController extends Controller
{
    
    function index(){

        return view("admin.mechanics.index");

    }

    function delete(Request $request){

        try{

            $mechanic = User::find($request->id);
            $mechanic->delete();
            return response()->json(["success" => true, "msg" => "Mecánico eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function store(MechanicStoreRequest $request){

        try{

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->password_reveal = $request->password;
            $user->role_id = 2;
            $user->save();

            return response()->json(["success" => true, "msg" => "Mecánico agregado"]);

        }catch(\Exception $e){
        
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(MechanicUpdateRequest $request){

        try{

            if(User::where("email", $request->email)->where("id", "<>", $request->id)->count() <= 0){
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->password_reveal = $request->password;
                $user->update();

                return response()->json(["success" => true, "msg" => "Mecánico actualizado"]);
            
            }else{

                return response()->json(["success" => false, "msg" => "Este email ya ha sido tomado"]);

            }

        }catch(\Exception $e){
        
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $mechanics = User::where('role_id', 2)->skip($skip)->take(20)->get();
            $mechanicsCount = User::where('role_id', 2)->count();

            return response()->json(["success" => true, "mechanics" => $mechanics, "mechanicsCount" => $mechanicsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function fetchAll(){
        try{

            $mechanics = User::where('role_id', 2)->get();
            return response()->json(["success" => true, "mechanics" => $mechanics]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
    }

}
