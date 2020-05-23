<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CarUpdateRequest;
use App\Car;

class CarController extends Controller
{

    function index(){
        return view('admin.cars.index');
    }
    
    function getCar($patent){

        try{

            $car = Car::where('patent', $patent)->first();
            return response()->json(["data" => $car, "success" => true, "msg" => "Vehiculo encontrado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor"]);
        }

    }

    function fetch($page = 1){
        try{

            $skip = ($page - 1) * 15;

            $cars = Car::skip($skip)->take(15)->get();
            $carsCount = Car::count();

            return response()->json(["success" => true, "cars" => $cars, "carsCount" => $carsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
    }

    function edit($id){

        $car = Car::findOrFail($id);
        return view('admin.cars.edit', ["car" => $car]);

    }

    function update(CarUpdateRequest $request){

        try{

            $car = Car::find($request->id);
            $car->brand = $request->brand;
            $car->model = $request->model;
            $car->year = $request->year;
            $car->color = $request->color;
            $car->update();

            return response()->json(["success" => true, "msg" => "Vechiulo actualizado exitosamente"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function delete(Request $request){
        
        try{
            
            $car = Car::findOrFail($request->id);
            $car->delete();
            
            return response()->json(["success" => true, "msg" => "Vehiculo eliminado exitosamente"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

}
