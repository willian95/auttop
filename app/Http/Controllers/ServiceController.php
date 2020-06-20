<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Service;

class ServiceController extends Controller
{
    
    function index(){
        return view('admin.services.index');
    }

    function store(ServiceStoreRequest $request){

        try{

            $service = new Service;
            $service->name = $request->name;
            $service->category_id = $request->categoryId;
            $service->save();

            return response()->json(["success" => true, "msg" => "Servicio creado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" =>"Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(ServiceUpdateRequest $request){

        try{

            $service = Service::find($request->id);
            $service->name = $request->name;
            $service->category_id = $request->selectedCategory;
            $service->update();

            return response()->json(["success" => true, "msg" => "Servicio actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" =>"Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $services = Service::with("category")->orderBy('category_id')->skip($skip)->take(20)->get();
            $servicesCount = Service::with("category")->count();

            return response()->json(["success" => true, "services" => $services, "servicesCount" => $servicesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function fetchAll(){

        try{

            $services = Service::all();
            return response()->json(["success" => true, "services" => $services]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function delete(Request $request){

        try{

            $service = Service::find($request->id);
            $service->delete();
            return response()->json(["success" => true, "msg" => "Servicio eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

}
