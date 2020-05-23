<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeliveryStoreRequest;
use App\Http\Requests\DeliveryUpdateRequest;
use App\User;

class DeliveryController extends Controller
{
    function index(){

        return view("admin.delivery.index");

    }

    function delete(Request $request){

        try{

            $mechanic = User::find($request->id);
            $mechanic->delete();
            return response()->json(["success" => true, "msg" => "Delivery eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function store(DeliveryStoreRequest $request){

        try{

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->password_reveal = $request->password;
            $user->role_id = 3;
            $user->save();

            return response()->json(["success" => true, "msg" => "Delivery agregado"]);

        }catch(\Exception $e){
        
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(DeliveryUpdateRequest $request){

        try{

            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->password_reveal = $request->password;
            $user->update();

            return response()->json(["success" => true, "msg" => "Delivery actualizado"]);

        }catch(\Exception $e){
        
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $deliveries = User::where('role_id', 3)->skip($skip)->take(20)->get();
            $deliveriesCount = User::where('role_id', 3)->count();

            return response()->json(["success" => true, "deliveries" => $deliveries, "deliveriesCount" => $deliveriesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function fetchAll(){
        try{

            $deliveries = User::where('role_id', 3)->get();
            return response()->json(["success" => true, "deliveries" => $deliveries]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
    }
}
