<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientUpdateRequest;
use App\Client;

class ClientController extends Controller
{


    function index(){
        return view('admin.clients.index');
    }

    function getClient($rut){

        try{

            $client = Client::where('rut', $rut)->first();
            return response()->json(["data" => $client, "success" => true, "msg" => "Usuario encontrado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor"]);
        }

    }

    function fetch($page = 1){
        try{

            $skip = ($page - 1) * 15;

            $clients = Client::skip($skip)->take(15)->get();
            $clientsCount = Client::count();

            return response()->json(["success" => true, "clients" => $clients, "clientsCount" => $clientsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
    }

    function edit($id){

        $client = Client::findOrFail($id);
        return view('admin.clients.edit', ["client" => $client]);

    }

    function update(ClientUpdateRequest $request){

        try{

            $client = Client::find($request->id);
            $client->name = $request->name;
            $client->email = $request->email;
            $client->location = $request->location;
            $client->address = $request->address;
            $client->telephone = $request->telephone;
            $client->update();

            return response()->json(["success" => true, "msg" => "Cliente actualizado exitosamente"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function delete(Request $request){
        
        try{
            
            $client = Client::findOrFail($request->id);
            $client->delete();
            
            return response()->json(["success" => true, "msg" => "Cliente eliminado exitosamente"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }


}
